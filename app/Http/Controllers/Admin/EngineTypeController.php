<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\EngineTypeDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateEngineTypeRequest;
use App\Http\Requests\Admin\UpdateEngineTypeRequest;
use App\Repositories\Admin\EngineTypeRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\EngineTypeTranslationRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class EngineTypeController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  EngineTypeRepository */
    private $engineTypeRepository;

    /** @var  EngineTypeTranslationRepository */
    private $translationRepository;

    /** @var  LanguageRepository */
    private $languageRepository;

    public function __construct(EngineTypeRepository $engineTypeRepo, EngineTypeTranslationRepository $translationRepo, LanguageRepository $languageRepo)
    {
        $this->engineTypeRepository = $engineTypeRepo;
        $this->translationRepository = $translationRepo;
        $this->languageRepository = $languageRepo;
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
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $engineTypeDataTable->render('admin.engine_types.index');
    }

    /**
     * Show the form for creating a new EngineType.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
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
        $engineType = $this->engineTypeRepository->saveRecord($request);

        Flash::success('Engine Type saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.engineTypes.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.engineTypes.edit', $engineType->id));
        } else {
            $redirect_to = redirect(route('admin.engineTypes.index'));
        }
        return $redirect_to;
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
        $locales = $this->languageRepository->orderBy('updated_at', 'ASC')->findWhere(['status' => 1]);
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $engineType);
        return view('admin.engine_types.show')->with([
            'engineType' => $engineType,
            'locales'    => $locales
        ]);
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

        $locales = $this->languageRepository->orderBy('updated_at', 'ASC')->findWhere(['status' => 1]);
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $engineType);
        return view('admin.engine_types.edit')->with([
            'engineType' => $engineType,
            'locales'    => $locales
        ]);
    }

    /**
     * Update the specified EngineType in storage.
     *
     * @param  int $id
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

        $engineType = $this->translationRepository->updateRecord($request, $engineType);

        Flash::success('Engine Type updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.engineTypes.create'));
        } else {
            $redirect_to = redirect(route('admin.engineTypes.index'));
        }
        return $redirect_to;
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

        if ($engineType->cars->count() > 0) {
            Flash::error('This engine type belongs to car. Cannot be deleted');
            return redirect(route('admin.engineTypes.index'));
        }

        $this->engineTypeRepository->delete($id);

        Flash::success('Engine Type deleted successfully.');
        return redirect(route('admin.engineTypes.index'));
    }
}