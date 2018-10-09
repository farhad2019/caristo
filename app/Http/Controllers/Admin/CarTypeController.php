<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarTypeDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarTypeRequest;
use App\Http\Requests\Admin\UpdateCarTypeRequest;
use App\Repositories\Admin\CarTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CarTypeController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarTypeRepository */
    private $carTypeRepository;

    public function __construct(CarTypeRepository $carTypeRepo)
    {
        $this->carTypeRepository = $carTypeRepo;
        $this->ModelName = 'carTypes';
        $this->BreadCrumbName = 'CarType';
    }

    /**
     * Display a listing of the CarType.
     *
     * @param CarTypeDataTable $carTypeDataTable
     * @return Response
     */
    public function index(CarTypeDataTable $carTypeDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $carTypeDataTable->render('admin.car_types.index');
    }

    /**
     * Show the form for creating a new CarType.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.car_types.create');
    }

    /**
     * Store a newly created CarType in storage.
     *
     * @param CreateCarTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateCarTypeRequest $request)
    {
        $input = $request->all();

        $carType = $this->carTypeRepository->create($input);

        Flash::success('Car Type saved successfully.');

        return redirect(route('admin.carTypes.index'));
    }

    /**
     * Display the specified CarType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carType = $this->carTypeRepository->findWithoutFail($id);

        if (empty($carType)) {
            Flash::error('Car Type not found');

            return redirect(route('admin.carTypes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $carType);
        return view('admin.car_types.show')->with('carType', $carType);
    }

    /**
     * Show the form for editing the specified CarType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carType = $this->carTypeRepository->findWithoutFail($id);

        if (empty($carType)) {
            Flash::error('Car Type not found');

            return redirect(route('admin.carTypes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $carType);
        return view('admin.car_types.edit')->with('carType', $carType);
    }

    /**
     * Update the specified CarType in storage.
     *
     * @param  int              $id
     * @param UpdateCarTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarTypeRequest $request)
    {
        $carType = $this->carTypeRepository->findWithoutFail($id);

        if (empty($carType)) {
            Flash::error('Car Type not found');

            return redirect(route('admin.carTypes.index'));
        }

        $carType = $this->carTypeRepository->update($request->all(), $id);

        Flash::success('Car Type updated successfully.');

        return redirect(route('admin.carTypes.index'));
    }

    /**
     * Remove the specified CarType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carType = $this->carTypeRepository->findWithoutFail($id);

        if (empty($carType)) {
            Flash::error('Car Type not found');

            return redirect(route('admin.carTypes.index'));
        }

        $this->carTypeRepository->delete($id);

        Flash::success('Car Type deleted successfully.');

        return redirect(route('admin.carTypes.index'));
    }
}
