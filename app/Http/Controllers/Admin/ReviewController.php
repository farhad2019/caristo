<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ReviewDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateReviewRequest;
use App\Http\Requests\Admin\UpdateReviewRequest;
use App\Repositories\Admin\ReviewRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class ReviewController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ReviewRepository */
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepo)
    {
        $this->reviewRepository = $reviewRepo;
        $this->ModelName = 'reviews';
        $this->BreadCrumbName = 'Review';
    }

    /**
     * Display a listing of the Review.
     *
     * @param ReviewDataTable $reviewDataTable
     * @return Response
     */
    public function index(ReviewDataTable $reviewDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $reviewDataTable->render('admin.reviews.index');
    }

    /**
     * Show the form for creating a new Review.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.reviews.create');
    }

    /**
     * Store a newly created Review in storage.
     *
     * @param CreateReviewRequest $request
     *
     * @return Response
     */
    public function store(CreateReviewRequest $request)
    {
        $input = $request->all();

        $review = $this->reviewRepository->create($input);

        Flash::success('Review saved successfully.');
        return redirect(route('admin.reviews.index'));
    }

    /**
     * Display the specified Review.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            Flash::error('Review not found');
            return redirect(route('admin.reviews.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $review);
        return view('admin.reviews.show')->with('review', $review);
    }

    /**
     * Show the form for editing the specified Review.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            Flash::error('Review not found');
            return redirect(route('admin.reviews.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $review);
        return view('admin.reviews.edit')->with('review', $review);
    }

    /**
     * Update the specified Review in storage.
     *
     * @param  int $id
     * @param UpdateReviewRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReviewRequest $request)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            Flash::error('Review not found');
            return redirect(route('admin.reviews.index'));
        }

        $review = $this->reviewRepository->update($request->all(), $id);

        Flash::success('Review updated successfully.');
        return redirect(route('admin.reviews.index'));
    }

    /**
     * Remove the specified Review from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            Flash::error('Review not found');
            return redirect(route('admin.reviews.index'));
        }

        $this->reviewRepository->delete($id);

        Flash::success('Review deleted successfully.');
        return redirect(route('admin.reviews.index'));
    }
}
