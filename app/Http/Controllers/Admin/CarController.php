<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarRequest;
use App\Http\Requests\Admin\UpdateCarRequest;
use App\Models\CarInteraction;
use App\Models\TradeInCar;
use App\Repositories\Admin\CarAttributeRepository;
use App\Repositories\Admin\CarBrandRepository;
use App\Repositories\Admin\CarFeatureRepository;
use App\Repositories\Admin\CarModelRepository;
use App\Repositories\Admin\CarRepository;
use App\Repositories\Admin\CarTypeRepository;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\EngineTypeRepository;
use App\Repositories\Admin\RegionalSpecificationRepository;
use App\Repositories\Admin\RegionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class CarController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarRepository */
    private $carRepository;

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

    public function __construct(CarRepository $carRepo, CategoryRepository $categoryRepo, CarBrandRepository $brandRepo, RegionalSpecificationRepository $regionalSpecRepo, EngineTypeRepository $engineTypeRepo, CarAttributeRepository $attributeRepo, CarTypeRepository $carTypeRepo, CarModelRepository $modelRepo, CarFeatureRepository $featureRepo, RegionRepository $regionRepo)
    {
        $this->carRepository = $carRepo;
        $this->categoryRepository = $categoryRepo;
        $this->brandRepository = $brandRepo;
        $this->regionalSpecRepository = $regionalSpecRepo;
        $this->engineTypeRepository = $engineTypeRepo;
        $this->attributeRepository = $attributeRepo;
        $this->carTypeRepository = $carTypeRepo;
        $this->modelRepository = $modelRepo;
        $this->featureRepository = $featureRepo;
        $this->regionRepository = $regionRepo;
        $this->ModelName = 'cars';
        $this->BreadCrumbName = 'Car';
    }

    /**
     * Display a listing of the Car.
     *
     * @param Request $request
     * @param CarDataTable $carDataTable
     * @return Response
     */
    public function index(Request $request, CarDataTable $carDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        $data = $request->all();
        $title = "";
        if ($data) {
            if (isset($data['type'])) {
                if ($data['type'] == 'cars') {
                    $title = "User's Cars";
                } else {
                    $title = "User's " . CarInteraction::$TYPES[$data['type']] . " Cars";
                }
            }
            return $carDataTable->interactionList($data)->render('admin.cars.index', ['title' => $title]);
        } else {
            return $carDataTable->render('admin.cars.index');
        }
        //return $carDataTable->render('admin.cars.index');
    }

    /**
     * Show the form for creating a new Car.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.cars.create');
    }

    /**
     * Store a newly created Car in storage.
     *
     * @param CreateCarRequest $request
     *
     * @return Response
     */
    public function store(CreateCarRequest $request)
    {
        $input = $request->all();

        $car = $this->carRepository->create($input);

        Flash::success('Car saved successfully.');

        return redirect(route('admin.cars.index'));
    }

    /**
     * Display the specified Car.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $car = $this->carRepository->findWithoutFail($id);

        if (empty($car)) {
            Flash::error('Car not found');

            return redirect(route('admin.cars.index'));
        }
        $attributes = $this->attributeRepository->all();
        $features = $this->featureRepository->all();
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $car);
        return view('admin.cars.show')->with([
            'myCar'      => $car,
            'attributes' => $attributes,
            'features'   => $features
        ]);
    }

    /**
     * Show the form for editing the specified Car.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $car = $this->carRepository->findWithoutFail($id);

        if (empty($car)) {
            Flash::error('Car not found');

            return redirect(route('admin.cars.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $car);
        return view('admin.cars.edit')->with('car', $car);
    }

    /**
     * Update the specified Car in storage.
     *
     * @param  int $id
     * @param UpdateCarRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarRequest $request)
    {
        $car = $this->carRepository->findWithoutFail($id);

        if (empty($car)) {
            Flash::error('Car not found');

            return redirect(route('admin.cars.index'));
        }

        $car = $this->carRepository->update($request->all(), $id);

        Flash::success('Car updated successfully.');

        return redirect(route('admin.cars.index'));
    }

    /**
     * Remove the specified Car from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $car = $this->carRepository->findWithoutFail($id);

        if (empty($car)) {
            Flash::error('Car not found');

            return redirect(route('admin.cars.index'));
        }

        if (TradeInCar::where('owner_car_id', $id)->orWhere('customer_car_id', $id)->count() > 0) {
            Flash::error('Car cannot be deleted, Trade request found');
            return redirect(route('admin.cars.index'));
        }

        $this->carRepository->delete($id);
        Flash::success('Car deleted successfully.');
        return redirect(route('admin.cars.index'));
    }
}
