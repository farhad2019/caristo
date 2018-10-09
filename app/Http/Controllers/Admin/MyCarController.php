<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\MyCarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateMyCarRequest;
use App\Http\Requests\Admin\UpdateMyCarRequest;
use App\Repositories\Admin\MyCarRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MyCarController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  MyCarRepository */
    private $myCarRepository;

    public function __construct(MyCarRepository $myCarRepo)
    {
        $this->myCarRepository = $myCarRepo;
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
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $myCarDataTable->render('admin.my_cars.index');
    }

    /**
     * Show the form for creating a new MyCar.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.my_cars.create');
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
        $input = $request->all();

        $myCar = $this->myCarRepository->create($input);

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

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $myCar);
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

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $myCar);
        return view('admin.my_cars.edit')->with('myCar', $myCar);
    }

    /**
     * Update the specified MyCar in storage.
     *
     * @param  int              $id
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
