<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\LanguageDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateLanguageRequest;
use App\Http\Requests\Admin\UpdateLanguageRequest;
use App\Repositories\Admin\LanguageRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LanguageController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  LanguageRepository */
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepo)
    {
        $this->languageRepository = $languageRepo;
        $this->ModelName = 'languages';
        $this->BreadCrumbName = 'Language';
    }

    /**
     * Display a listing of the Language.
     *
     * @param LanguageDataTable $languageDataTable
     * @return Response
     */
    public function index(LanguageDataTable $languageDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $languageDataTable->render('admin.languages.index');
    }

    /**
     * Show the form for creating a new Language.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.languages.create');
    }

    /**
     * Store a newly created Language in storage.
     *
     * @param CreateLanguageRequest $request
     *
     * @return Response
     */
    public function store(CreateLanguageRequest $request)
    {
        $input = $request->all();

        $language = $this->languageRepository->create($input);

        Flash::success('Language saved successfully.');

        return redirect(route('admin.languages.index'));
    }

    /**
     * Display the specified Language.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $language = $this->languageRepository->findWithoutFail($id);

        if (empty($language)) {
            Flash::error('Language not found');

            return redirect(route('admin.languages.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $language);
        return view('admin.languages.show')->with('language', $language);
    }

    /**
     * Show the form for editing the specified Language.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $language = $this->languageRepository->findWithoutFail($id);

        if (empty($language)) {
            Flash::error('Language not found');

            return redirect(route('admin.languages.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $language);
        return view('admin.languages.edit')->with('language', $language);
    }

    /**
     * Update the specified Language in storage.
     *
     * @param  int              $id
     * @param UpdateLanguageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLanguageRequest $request)
    {
        $language = $this->languageRepository->findWithoutFail($id);

        if (empty($language)) {
            Flash::error('Language not found');

            return redirect(route('admin.languages.index'));
        }

        $language = $this->languageRepository->update($request->all(), $id);

        Flash::success('Language updated successfully.');

        return redirect(route('admin.languages.index'));
    }

    /**
     * Remove the specified Language from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $language = $this->languageRepository->findWithoutFail($id);

        if (empty($language)) {
            Flash::error('Language not found');

            return redirect(route('admin.languages.index'));
        }

        $this->languageRepository->delete($id);

        Flash::success('Language deleted successfully.');

        return redirect(route('admin.languages.index'));
    }
}
