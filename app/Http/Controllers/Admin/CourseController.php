<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CourseDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\CourseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

/**
 * Class CourseController
 * @package App\Http\Controllers\Admin
 */
class CourseController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CourseRepository */
    private $courseRepository;

    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CourseRepository $courseRepo, CategoryRepository $categoryRepo)
    {
        $this->courseRepository = $courseRepo;
        $this->categoryRepository = $categoryRepo;
        $this->ModelName = 'courses';
        $this->BreadCrumbName = 'Course';
    }

    /**
     * Display a listing of the Course.
     *
     * @param CourseDataTable $courseDataTable
     * @return Response
     */
    public function index(CourseDataTable $courseDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $courseDataTable->render('admin.courses.index');
    }

    /**
     * Show the form for creating a new Course.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getCoachCategories()->pluck('name', 'id');

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.courses.create')->with([
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created Course in storage.
     *
     * @param CreateCourseRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateCourseRequest $request)
    {
        $this->courseRepository->saveRecord($request);

        Flash::success('Course saved successfully.');
        return redirect(route('admin.courses.index'));
    }

    /**
     * Display the specified Course.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            Flash::error('Course not found');
            return redirect(route('admin.courses.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $course);
        return view('admin.courses.show')->with('course', $course);
    }

    /**
     * Show the form for editing the specified Course.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            Flash::error('Course not found');
            return redirect(route('admin.courses.index'));
        }

        $categories = $this->categoryRepository->getCoachCategories()->pluck('name', 'id');
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $course);
        return view('admin.courses.edit')->with([
            'course'     => $course,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified Course in storage.
     *
     * @param  int $id
     * @param UpdateCourseRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateCourseRequest $request)
    {
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            Flash::error('Course not found');
            return redirect(route('admin.courses.index'));
        }
        $course = $this->courseRepository->update($request->all(), $id);

        Flash::success('Course updated successfully.');
        return redirect(route('admin.courses.index'));
    }

    /**
     * Remove the specified Course from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            Flash::error('Course not found');
            return redirect(route('admin.courses.index'));
        }
        $this->courseRepository->delete($id);

        Flash::success('Course deleted successfully.');
        return redirect(route('admin.courses.index'));
    }
}