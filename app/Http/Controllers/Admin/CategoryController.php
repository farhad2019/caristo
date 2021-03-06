<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CategoryDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Media;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $root = $this->parent + $this->categoryRepository->getRootCategories()->pluck('name', 'id')->toArray();
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.categories.create')->with('root', $root);
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        if (empty($category)) {
            Flash::error('Category not found');
            return redirect(route('admin.categories.index'));
        }

        $root = $this->parent + $this->categoryRepository->getRootCategories()->pluck('name', 'id')->toArray();
        unset($root[$id]);

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $category);
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        if (empty($category)) {
            Flash::error('Category not found');
            return redirect(route('admin.categories.index'));
        }

        if ($category->media->where('media_type', Media::IMAGE)->count() == 0) {
            $validatedData = $request->validate([
                'media' => 'required|image|mimes:jpg,jpeg,png|max:500',
            ], [
                'media.required' => 'The media is required.',
                'media.mimes'    => 'The media must be a file of type: jpg, jpeg, png.',
                'media.max'      => 'The media may not be greater than 500 kilobytes.',
            ]);
        }
        if ($category->media->where('media_type', Media::BANNER_IMAGE)->count() == 0) {
            $validatedData = $request->validate([
                'banner_media'   => 'required',
                'banner_media.*' => 'image|mimes:jpg,jpeg,png',
            ], [
                'banner_media.required' => 'The banner image field is required.',
                'banner_media.*.image'  => 'Please select valid banner image file.',
                'banner_media.*.mimes'  => 'The banner image must be a file of type: jpg, jpeg, png.',
                'banner_media.max'      => 'The banner image may not be greater than 500 kilobytes.',
            ]);
        }

        $this->categoryRepository->updateRecord($category, $request);

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

        $this->categoryRepository->deleteRecord($id);

        Flash::success('Category deleted successfully.');
        return redirect(route('admin.categories.index'));
    }
}