<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\EngineTypeDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateEngineTypeRequest;
use App\Http\Requests\Admin\UpdateEngineTypeRequest;
use App\Repositories\Admin\EngineTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class EngineTypeController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  EngineTypeRepository */
    private $engineTypeRepository;

    public function __construct(EngineTypeRepository $engineTypeRepo)
    {
        $this->engineTypeRepository = $engineTypeRepo;
        $this->ModelName = 'engineTypes';
        $this->BreadCrumbName = 'EngineType';
    }

    /**
     * Display a listing of the EngineType.
     *
     * @param EngineTypeDataTable $engineTypeDataTable
     * @return Response
     */
    public function index(EngineTypeDataTable $engineTypeDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $engineTypeDataTable->render('admin.engine_types.index');
    }

    /**
     * Show the form for creating a new EngineType.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.engine_types.create');
    }

    /**
     * Store a newly created EngineType in storage.
     *
     * @param CreateEngineTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateEngineTypeRequest $request)
    {
        $input = $request->all();

        $engineType = $this->engineTypeRepository->create($input);

        Flash::success('Engine Type saved successfully.');

        return redirect(route('admin.engineTypes.index'));
    }

    /**
     * Display the specified EngineType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $engineType = $this->engineTypeRepository->findWithoutFail($id);

        if (empty($engineType)) {
            Flash::error('Engine Type not found');

            return redirect(route('admin.engineTypes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $engineType);
        return view('admin.engine_types.show')->with('engineType', $engineType);
    }

    /**
     * Show the form for editing the specified EngineType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $engineType = $this->engineTypeRepository->findWithoutFail($id);

        if (empty($engineType)) {
            Flash::error('Engine Type not found');

            return redirect(route('admin.engineTypes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $engineType);
        return view('admin.engine_types.edit')->with('engineType', $engineType);
    }

    /**
     * Update the specified EngineType in storage.
     *
     * @param  int              $id
     * @param UpdateEngineTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEngineTypeRequest $request)
    {
        $engineType = $this->engineTypeRepository->findWithoutFail($id);

        if (empty($engineType)) {
            Flash::error('Engine Type not found');

            return redirect(route('admin.engineTypes.index'));
        }

        $engineType = $this->engineTypeRepository->update($request->all(), $id);

        Flash::success('Engine Type updated successfully.');

        return redirect(route('admin.engineTypes.index'));
    }

    /**
     * Remove the specified EngineType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $engineType = $this->engineTypeRepository->findWithoutFail($id);

        if (empty($engineType)) {
            Flash::error('Engine Type not found');

            return redirect(route('admin.engineTypes.index'));
        }

        $this->engineTypeRepository->delete($id);

        Flash::success('Engine Type deleted successfully.');

        return redirect(route('admin.engineTypes.index'));
    }
}
