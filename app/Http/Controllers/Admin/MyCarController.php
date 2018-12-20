<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\MyCarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateMyCarRequest;
use App\Http\Requests\Admin\UpdateMyCarRequest;
use App\Models\CarRegion;
use App\Models\MyCar;
use App\Models\RegionalSpecification;
use App\Repositories\Admin\CarAttributeRepository;
use App\Repositories\Admin\CarBrandRepository;
use App\Repositories\Admin\CarFeatureRepository;
use App\Repositories\Admin\CarModelRepository;
use App\Repositories\Admin\CarTypeRepository;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\EngineTypeRepository;
use App\Repositories\Admin\MyCarRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\RegionalSpecificationRepository;
use App\Repositories\Admin\RegionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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

    /** @var  CarFeatureRepository */
    private $featureRepository;

    /** @var  RegionRepository */
    private $regionRepository;

    public function __construct(MyCarRepository $myCarRepo, CategoryRepository $categoryRepo, CarBrandRepository $brandRepo, RegionalSpecificationRepository $regionalSpecRepo, EngineTypeRepository $engineTypeRepo, CarAttributeRepository $attributeRepo, CarTypeRepository $carTypeRepo, CarModelRepository $modelRepo, CarFeatureRepository $featureRepo, RegionRepository $regionRepo)
    {
        $this->myCarRepository = $myCarRepo;
        $this->categoryRepository = $categoryRepo;
        $this->brandRepository = $brandRepo;
        $this->regionalSpecRepository = $regionalSpecRepo;
        $this->engineTypeRepository = $engineTypeRepo;
        $this->attributeRepository = $attributeRepo;
        $this->carTypeRepository = $carTypeRepo;
        $this->modelRepository = $modelRepo;
        $this->featureRepository = $featureRepo;
        $this->regionRepository = $regionRepo;
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
        /*if (Auth::user()->hasRole('showroom-owner')) {
            return view('admin.showroom.profile')->with('user', Auth::user());
        }*/
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
        $features = $this->featureRepository->all();
        $carTypes = $this->carTypeRepository->all()->pluck('name', 'id');
        $carModels = $this->modelRepository->all()->pluck('name', 'id');
        $regions = $this->regionRepository->all()->pluck('name', 'id');
        $limited = null;

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.my_cars.create')->with([
            'categories'        => $categories,
            'regional_specs'    => $regional_specs,
            'engineType'        => $engineType,
            'attributes'        => $attributes,
            'features'          => $features,
            'transmission_type' => MyCar::$TRANSMISSION_TYPE_TEXT,
            'carTypes'          => $carTypes,
            'carModels'         => $carModels,
            'regions'           => $regions,
            'brands'            => $brands,
            'limited'            => $limited
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $myCar = $this->myCarRepository->saveRecord($request);
        if ($request->category_id != MyCar::LIMITEDADDITION) {
            if (!empty($request->attribute)) {
                foreach ($request->attribute as $key => $item) {
                    $myCar->carAttributes()->attach($key, ['value' => $item]);
                }
            }
        }

        Flash::success('Car saved successfully.');
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
            Flash::error('Car not found');

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
            Flash::error('Car not found');
            return redirect(route('admin.myCars.index'));
        }
        $limited = json_decode($myCar->limited_edition_specs,true);
      
        
        $brands = $this->brandRepository->all()->pluck('name', 'id');
        $categories = $this->categoryRepository->getCarCategories()->pluck('name', 'id');
        $regional_specs = $this->regionalSpecRepository->all()->pluck('name', 'id');
        $engineType = $this->engineTypeRepository->all()->pluck('name', 'id');
        $attributes = $this->attributeRepository->all();
        $features = $this->featureRepository->all();
        $carTypes = $this->carTypeRepository->all()->pluck('name', 'id');
        $carModels = $this->modelRepository->all()->pluck('name', 'id');
        $regions = $this->regionRepository->all()->pluck('name', 'id');
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $myCar);
        return view('admin.my_cars.edit')->with([
            'myCar'             => $myCar,
            'categories'        => $categories,
            'regional_specs'    => $regional_specs,
            'engineType'        => $engineType,
            'attributes'        => $attributes,
            'features'          => $features,
            'transmission_type' => MyCar::$TRANSMISSION_TYPE_TEXT,
            'carTypes'          => $carTypes,
            'carModels'         => $carModels,
            'brands'            => $brands,
            'regions'           => $regions,
            'limited'           => $limited,
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

        if ($request->category_id != $myCar->category_id) {
            CarRegion::where('car_id', $id)->delete();
        }
        if (empty($myCar)) {
            Flash::error('Car not found');
            return redirect(route('admin.myCars.index'));
        }

        $myCar = $this->myCarRepository->updateRecord($request, $myCar);

        Flash::success('Car updated successfully.');
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
            Flash::error('Car not found');
            return redirect(route('admin.myCars.index'));
        }

        $this->myCarRepository->delete($id);

        Flash::success('Car deleted successfully.');
        return redirect(route('admin.myCars.index'));
    }
}