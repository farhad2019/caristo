<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\PageDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreatePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\PageRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\PageTranslationRepository;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Response;

class PageController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  PageRepository */
    private $pageRepository;

    /** @var  LanguageRepository */
    private $languageRepository;

    /** @var  LanguageRepository */
    private $pageTranslationRepository;

    public function __construct(PageRepository $pageRepo, PageTranslationRepository $pageTranslationRepo, LanguageRepository $languageRepo)
    {
        $this->pageRepository = $pageRepo;
        $this->pageTranslationRepository = $pageTranslationRepo;
        $this->languageRepository = $languageRepo;
        $this->ModelName = 'pages';
        $this->BreadCrumbName = 'Page';
    }

    /**
     * Display a listing of the Page.
     *
     * @param PageDataTable $pageDataTable
     * @return Response
     */
    public function index(PageDataTable $pageDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $pageDataTable->render('admin.pages.index');
    }

    /**
     * Show the form for creating a new Page.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.pages.create');
    }

    /**
     * Store a newly created Page in storage.
     *
     * @param CreatePageRequest $request
     *
     * @return Response
     */
    public function store(CreatePageRequest $request)
    {
        $input = $request->all();

        $page = $this->pageRepository->create($input);

        Flash::success('Page saved successfully.');

        if (isset($input['continue'])) {
            $redirect_to = redirect(route('admin.pages.create'));
        } elseif (isset($input['translation'])) {
            $redirect_to = redirect(route('admin.pages.edit', $page->id));
        } else {
            $redirect_to = redirect(route('admin.pages.index'));
        }
        return $redirect_to;
    }

    /**
     * Display the specified Page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('admin.pages.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $page);
        return view('admin.pages.show')->with('page', $page);
    }

    /**
     * Show the form for editing the specified Page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');
            return redirect(route('admin.pages.index'));
        }

        $locales = $this->languageRepository->findWhere(['status' => 1])->all();

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $page);
        return view('admin.pages.edit')
            ->with([
                'page'    => $page,
                'locales' => $locales
            ]);
    }

    /**
     * Update the specified Page in storage.
     *
     * @param  int $id
     * @param UpdatePageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePageRequest $request)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('admin.pages.index'));
        }

        $localeList = [];
        foreach ($page->translations as $translation) {
            $localeList[$translation->id] = $translation->locale;
        }

        foreach ($request->title as $key => $title) {
            if ($title != '') {
                $locale = $this->languageRepository->find($key)->code;
                $update_data['page_id'] = $page->id;
                $update_data['locale'] = $locale;
                $update_data['title'] = $title;
                $update_data['content'] = $request['content'][$key];
                $update_data['status'] = isset($request['status'][$key]) ? $request['status'][$key] : 0;
                if (array_search($locale, $localeList)) {
                    $translation_id = array_search($locale, $localeList);
                    $this->pageTranslationRepository->update($update_data, $translation_id);
                } else {
                    $this->pageTranslationRepository->create($update_data);
                }
            }
        }

        $input['slug'] = $request->slug;
        $input['status'] = $request->status;
        $page = $this->pageRepository->update($input, $id);

        Flash::success('Page updated successfully.');
        return redirect(route('admin.pages.index'));
    }

    /**
     * Remove the specified Page from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');
            return redirect(route('admin.pages.index'));
        }

        $this->pageRepository->delete($id);

        Flash::success('Page deleted successfully.');
        return redirect(route('admin.pages.index'));
    }
}
