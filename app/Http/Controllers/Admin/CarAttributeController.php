<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarAttributeDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarAttributeRequest;
use App\Http\Requests\Admin\UpdateCarAttributeRequest;
use App\Repositories\Admin\CarAttributeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CarAttributeController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarAttributeRepository */
    private $carAttributeRepository;

    public function __construct(CarAttributeRepository $carAttributeRepo)
    {
        $this->carAttributeRepository = $carAttributeRepo;
        $this->ModelName = 'carAttributes';
        $this->BreadCrumbName = 'CarAttribute';
    }

    /**
     * Display a listing of the CarAttribute.
     *
     * @param CarAttributeDataTable $carAttributeDataTable
     * @return Response
     */
    public function index(CarAttributeDataTable $carAttributeDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $carAttributeDataTable->render('admin.car_attributes.index');
    }

    /**
     * Show the form for creating a new CarAttribute.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.car_attributes.create');
    }

    /**
     * Store a newly created CarAttribute in storage.
     *
     * @param CreateCarAttributeRequest $request
     *
     * @return Response
     */
    public function store(CreateCarAttributeRequest $request)
    {
        $input = $request->all();

        $carAttribute = $this->carAttributeRepository->create($input);

        Flash::success('Car Attribute saved successfully.');

        return redirect(route('admin.carAttributes.index'));
    }

    /**
     * Display the specified CarAttribute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            Flash::error('Car Attribute not found');

            return redirect(route('admin.carAttributes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $carAttribute);
        return view('admin.car_attributes.show')->with('carAttribute', $carAttribute);
    }

    /**
     * Show the form for editing the specified CarAttribute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            Flash::error('Car Attribute not found');

            return redirect(route('admin.carAttributes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $carAttribute);
        return view('admin.car_attributes.edit')->with('carAttribute', $carAttribute);
    }

    /**
     * Update the specified CarAttribute in storage.
     *
     * @param  int              $id
     * @param UpdateCarAttributeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarAttributeRequest $request)
    {
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            Flash::error('Car Attribute not found');

            return redirect(route('admin.carAttributes.index'));
        }

        $carAttribute = $this->carAttributeRepository->update($request->all(), $id);

        Flash::success('Car Attribute updated successfully.');

        return redirect(route('admin.carAttributes.index'));
    }

    /**
     * Remove the specified CarAttribute from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            Flash::error('Car Attribute not found');

            return redirect(route('admin.carAttributes.index'));
        }

        $this->carAttributeRepository->delete($id);

        Flash::success('Car Attribute deleted successfully.');

        return redirect(route('admin.carAttributes.index'));
    }
}
