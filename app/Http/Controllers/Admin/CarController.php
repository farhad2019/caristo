<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarRequest;
use App\Http\Requests\Admin\UpdateCarRequest;
use App\Repositories\Admin\CarRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CarController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarRepository */
    private $carRepository;

    public function __construct(CarRepository $carRepo)
    {
        $this->carRepository = $carRepo;
        $this->ModelName = 'cars';
        $this->BreadCrumbName = 'Car';
    }

    /**
     * Display a listing of the Car.
     *
     * @param CarDataTable $carDataTable
     * @return Response
     */
    public function index(CarDataTable $carDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $carDataTable->render('admin.cars.index');
    }

    /**
     * Show the form for creating a new Car.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
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

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $car);
        return view('admin.cars.show')->with('car', $car);
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

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $car);
        return view('admin.cars.edit')->with('car', $car);
    }

    /**
     * Update the specified Car in storage.
     *
     * @param  int              $id
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

        $this->carRepository->delete($id);

        Flash::success('Car deleted successfully.');

        return redirect(route('admin.cars.index'));
    }
}
