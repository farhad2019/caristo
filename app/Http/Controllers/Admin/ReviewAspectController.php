<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ReviewAspectDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateReviewAspectRequest;
use App\Http\Requests\Admin\UpdateReviewAspectRequest;
use App\Repositories\Admin\ReviewAspectRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class ReviewAspectController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ReviewAspectRepository */
    private $reviewAspectRepository;

    public function __construct(ReviewAspectRepository $reviewAspectRepo)
    {
        $this->reviewAspectRepository = $reviewAspectRepo;
        $this->ModelName = 'reviewAspects';
        $this->BreadCrumbName = 'ReviewAspect';
    }

    /**
     * Display a listing of the ReviewAspect.
     *
     * @param ReviewAspectDataTable $reviewAspectDataTable
     * @return Response
     */
    public function index(ReviewAspectDataTable $reviewAspectDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $reviewAspectDataTable->render('admin.review_aspects.index');
    }

    /**
     * Show the form for creating a new ReviewAspect.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.review_aspects.create');
    }

    /**
     * Store a newly created ReviewAspect in storage.
     *
     * @param CreateReviewAspectRequest $request
     *
     * @return Response
     */
    public function store(CreateReviewAspectRequest $request)
    {
        $input = $request->all();
        $reviewAspect = $this->reviewAspectRepository->create($input);

        Flash::success('Review Aspect saved successfully.');
        return redirect(route('admin.reviewAspects.index'));
    }

    /**
     * Display the specified ReviewAspect.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $reviewAspect = $this->reviewAspectRepository->findWithoutFail($id);

        if (empty($reviewAspect)) {
            Flash::error('Review Aspect not found');
            return redirect(route('admin.reviewAspects.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $reviewAspect);
        return view('admin.review_aspects.show')->with('reviewAspect', $reviewAspect);
    }

    /**
     * Show the form for editing the specified ReviewAspect.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reviewAspect = $this->reviewAspectRepository->findWithoutFail($id);

        if (empty($reviewAspect)) {
            Flash::error('Review Aspect not found');
            return redirect(route('admin.reviewAspects.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $reviewAspect);
        return view('admin.review_aspects.edit')->with('reviewAspect', $reviewAspect);
    }

    /**
     * Update the specified ReviewAspect in storage.
     *
     * @param  int $id
     * @param UpdateReviewAspectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReviewAspectRequest $request)
    {
        $reviewAspect = $this->reviewAspectRepository->findWithoutFail($id);

        if (empty($reviewAspect)) {
            Flash::error('Review Aspect not found');
            return redirect(route('admin.reviewAspects.index'));
        }

        $reviewAspect = $this->reviewAspectRepository->update($request->all(), $id);

        Flash::success('Review Aspect updated successfully.');
        return redirect(route('admin.reviewAspects.index'));
    }

    /**
     * Remove the specified ReviewAspect from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reviewAspect = $this->reviewAspectRepository->findWithoutFail($id);

        if (empty($reviewAspect)) {
            Flash::error('Review Aspect not found');
            return redirect(route('admin.reviewAspects.index'));
        }

        $this->reviewAspectRepository->delete($id);

        Flash::success('Review Aspect deleted successfully.');
        return redirect(route('admin.reviewAspects.index'));
    }
}
