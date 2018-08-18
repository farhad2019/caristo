<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CategoryDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Repositories\Admin\CategoryRepository;
use Flash;
use Response;

class CategoryController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CategoryRepository */
    private $categoryRepository;

    private $parent = [0 => '(No Parent)'];

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
        $this->ModelName = 'categories';
        $this->BreadCrumbName = 'Category';
    }

    /**
     * Display a listing of the Category.
     *
     * @param CategoryDataTable $categoryDataTable
     * @return Response
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $categoryDataTable->render('admin.categories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);

        $root = $this->parent + $this->categoryRepository->getRootCategories()->pluck('name', 'id')->toArray();

        return view('admin.categories.create')->with('root', $root);
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {

        $category = $this->categoryRepository->saveRecord($request);

        Flash::success('Category saved successfully.');

        return redirect(route('admin.categories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('admin.categories.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $category);
        return view('admin.categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('admin.categories.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $category);

        $root = $this->parent + $this->categoryRepository->getRootCategories()->pluck('name', 'id')->toArray();

        unset($root[$id]);

        return view('admin.categories.edit')->with([
            'category' => $category,
            'root'     => $root
        ]);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('admin.categories.index'));
        }

        $this->categoryRepository->updateRecord($category, $request);
//        $category = $this->categoryRepository->update($request->all(), $id);

        Flash::success('Category updated successfully.');

        return redirect(route('admin.categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('admin.categories.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success('Category deleted successfully.');

        return redirect(route('admin.categories.index'));
    }
}
