<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\NewsDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\CreateNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\NewsRepository;
use Flash;
use Response;

class NewsController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  NewsRepository */
    private $newsRepository;

    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(NewsRepository $newsRepo, CategoryRepository $categoryRepository)
    {
        $this->newsRepository = $newsRepo;
        $this->categoryRepository = $categoryRepository;
        $this->ModelName = 'news';
        $this->BreadCrumbName = 'News';
    }

    /**
     * Display a listing of the News.
     *
     * @param NewsDataTable $newsDataTable
     * @return Response
     */
    public function index(NewsDataTable $newsDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $newsDataTable->render('admin.news.index');
    }

    /**
     * Show the form for creating a new News.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        $categories = [];
        $cats = $this->categoryRepository->getRootCategories();
        foreach ($cats as $category) {
            if ($category->childCategory()->count() > 0) {
                $categories[$category->name] = $category->childCategory->pluck('name', 'id');
            } else {
                $categories[$category->name] = [$category->id => $category->name];
            }
        }
        return view('admin.news.create')->with('categories', $categories);
    }

    /**
     * Store a newly created News in storage.
     *
     * @param CreateNewsRequest $request
     *
     * @return Response
     */
    public function store(CreateNewsRequest $request)
    {
        $news = $this->newsRepository->createRecord($request);

        Flash::success('News saved successfully.');

        return redirect(route('admin.news.index'));
    }

    /**
     * Display the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('admin.news.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $news);
        return view('admin.news.show')->with('news', $news);
    }

    /**
     * Show the form for editing the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('admin.news.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $news);
        $categories = [];
        $cats = $this->categoryRepository->getRootCategories();
        foreach ($cats as $category) {
            if ($category->childCategory()->count() > 0) {
                $categories[$category->name] = $category->childCategory->pluck('name', 'id');
            } else {
                $categories[$category->name] = [$category->id => $category->name];
            }
        }


        return view('admin.news.edit')->with([
            'news'       => $news,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified News in storage.
     *
     * @param  int $id
     * @param UpdateNewsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNewsRequest $request)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('admin.news.index'));
        }

        $news = $this->newsRepository->updateRecord($request, $id);

        Flash::success('News updated successfully.');

        return redirect(route('admin.news.index'));
    }

    /**
     * Remove the specified News from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('admin.news.index'));
        }

        $this->newsRepository->delete($id);

        Flash::success('News deleted successfully.');

        return redirect(route('admin.news.index'));
    }
}
