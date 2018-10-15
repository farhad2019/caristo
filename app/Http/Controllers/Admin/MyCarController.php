<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\MyCarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateMyCarRequest;
use App\Http\Requests\Admin\UpdateMyCarRequest;
use App\Models\MyCar;
use App\Models\RegionalSpecification;
use App\Repositories\Admin\CarAttributeRepository;
use App\Repositories\Admin\CarBrandRepository;
use App\Repositories\Admin\CarModelRepository;
use App\Repositories\Admin\CarTypeRepository;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\EngineTypeRepository;
use App\Repositories\Admin\MyCarRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\RegionalSpecificationRepository;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class MyCarController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  MyCarRepository */
    private $myCarRepository;

    /** @var  CategoryRepository */
    private $categoryRepository;

    /** @var  CarBrandRepository */
    private $brandRepository;

    /** @var  RegionalSpecificationRepository */
    private $regionalSpecRepository;

    /** @var  EngineTypeRepository */
    private $engineTypeRepository;

    /** @var  CarAttributeRepository */
    private $attributeRepository;

    /** @var  CarTypeRepository */
    private $carTypeRepository;

    /** @var  CarModelRepository */
    private $modelRepository;

    public function __construct(MyCarRepository $myCarRepo, CategoryRepository $categoryRepo, CarBrandRepository $brandRepo, RegionalSpecificationRepository $regionalSpecRepo, EngineTypeRepository $engineTypeRepo, CarAttributeRepository $attributeRepo, CarTypeRepository $carTypeRepo, CarModelRepository $modelRepo)
    {
        $this->myCarRepository = $myCarRepo;
        $this->categoryRepository = $categoryRepo;
        $this->brandRepository = $brandRepo;
        $this->regionalSpecRepository = $regionalSpecRepo;
        $this->engineTypeRepository = $engineTypeRepo;
        $this->attributeRepository = $attributeRepo;
        $this->carTypeRepository = $carTypeRepo;
        $this->modelRepository = $modelRepo;
        $this->ModelName = 'myCars';
        $this->BreadCrumbName = 'MyCar';
    }

    /**
     * Display a listing of the MyCar.
     *
     * @param MyCarDataTable $myCarDataTable
     * @return Response
     */
    public function index(MyCarDataTable $myCarDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $myCarDataTable->render('admin.my_cars.index');
    }

    /**
     * Show the form for creating a new MyCar.
     *
     * @return Response
     */
    public function create()
    {
        $brands = $this->brandRepository->all()->pluck('name', 'id');
        $categories = $this->categoryRepository->getCarCategories()->pluck('name', 'id');
        $regional_specs = $this->regionalSpecRepository->all()->pluck('name', 'id');
        $engineType = $this->engineTypeRepository->all()->pluck('name', 'id');
        $attributes = $this->attributeRepository->all();
        $carTypes = $this->carTypeRepository->all()->pluck('name', 'id');

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.my_cars.create')->with([
            'categories'        => $categories,
            'regional_specs'    => $regional_specs,
            'engineType'        => $engineType,
            'attributes'        => $attributes,
            'transmission_type' => MyCar::$TRANSMISSION_TYPE_TEXT,
            'carTypes'          => $carTypes,
            'brands'            => $brands
        ]);
    }

    /**
     * Store a newly created MyCar in storage.
     *
     * @param CreateMyCarRequest $request
     *
     * @return Response
     */
    public function store(CreateMyCarRequest $request)
    {
        $myCar = $this->myCarRepository->saveRecord($request);

        if (!empty($request->attribute)) {
            foreach ($request->attribute as $key => $item) {
                $myCar->carAttributes()->attach($key, ['value' => $item]);
            }
        }

        Flash::success('My Car saved successfully.');
        return redirect(route('admin.myCars.index'));
    }

    /**
     * Display the specified MyCar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $myCar = $this->myCarRepository->findWithoutFail($id);

        if (empty($myCar)) {
            Flash::error('My Car not found');

            return redirect(route('admin.myCars.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $myCar);
        return view('admin.my_cars.show')->with('myCar', $myCar);
    }

    /**
     * Show the form for editing the specified MyCar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $myCar = $this->myCarRepository->findWithoutFail($id);
        if (empty($myCar)) {
            Flash::error('My Car not found');
            return redirect(route('admin.myCars.index'));
        }

        $brands = $this->brandRepository->all()->pluck('name', 'id');
        $categories = $this->categoryRepository->getCarCategories()->pluck('name', 'id');
        $regional_specs = $this->regionalSpecRepository->all()->pluck('name', 'id');
        $engineType = $this->engineTypeRepository->all()->pluck('name', 'id');
        $attributes = $this->attributeRepository->all();
        $carTypes = $this->carTypeRepository->all()->pluck('name', 'id');
        $carModels = $this->modelRepository->all()->pluck('name', 'id');

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $myCar);
        return view('admin.my_cars.edit')->with([
            'myCar'             => $myCar,
            'categories'        => $categories,
            'regional_specs'    => $regional_specs,
            'engineType'        => $engineType,
            'attributes'        => $attributes,
            'transmission_type' => MyCar::$TRANSMISSION_TYPE_TEXT,
            'carTypes'          => $carTypes,
            'carModels'         => $carModels,
            'brands'            => $brands
        ]);
    }

    /**
     * Update the specified MyCar in storage.
     *
     * @param  int $id
     * @param UpdateMyCarRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMyCarRequest $request)
    {
        $myCar = $this->myCarRepository->findWithoutFail($id);

        if (empty($myCar)) {
            Flash::error('My Car not found');

            return redirect(route('admin.myCars.index'));
        }

        $myCar = $this->myCarRepository->update($request->all(), $id);

        Flash::success('My Car updated successfully.');

        return redirect(route('admin.myCars.index'));
    }

    /**
     * Remove the specified MyCar from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $myCar = $this->myCarRepository->findWithoutFail($id);

        if (empty($myCar)) {
            Flash::error('My Car not found');

            return redirect(route('admin.myCars.index'));
        }

        $this->myCarRepository->delete($id);

        Flash::success('My Car deleted successfully.');

        return redirect(route('admin.myCars.index'));
    }
}