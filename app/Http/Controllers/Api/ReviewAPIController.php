<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateReviewAPIRequest;
use App\Http\Requests\Api\UpdateReviewAPIRequest;
use App\Models\Review;
use App\Repositories\Admin\ReviewDetailRepository;
use App\Repositories\Admin\ReviewRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ReviewController
 * @package App\Http\Controllers\Api
 */
class ReviewAPIController extends AppBaseController
{
    /** @var  ReviewRepository */
    private $reviewRepository;

    /** @var  ReviewDetailRepository */
    private $reviewDetailRepository;

    public function __construct(ReviewRepository $reviewRepo, ReviewDetailRepository $reviewDetailRepo)
    {
        $this->reviewRepository = $reviewRepo;
        $this->reviewDetailRepository = $reviewDetailRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/reviews",
     *      summary="Get a listing of the Reviews.",
     *      tags={"Review"},
     *      description="Get all Reviews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Review")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->reviewRepository->pushCriteria(new RequestCriteria($request));
        $this->reviewRepository->pushCriteria(new LimitOffsetCriteria($request));
        $reviews = $this->reviewRepository->all();

        return $this->sendResponse($reviews->toArray(), 'Reviews retrieved successfully');
    }

    /**
     * @param CreateReviewAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/reviews",
     *      summary="Store a newly created Review in storage",
     *      tags={"Review"},
     *      description="Store Review",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Review that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Review")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Review"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReviewAPIRequest $request)
    {
        if (Auth::user()->reviews()->where('car_id', $request->car_id)->count() > 0) {
            return $this->sendError('Your review had already been record for this car.');
        }

        $reviews = $this->reviewRepository->saveRecord($request);
        foreach ($request->rating as $key => $value) {
            $this->reviewDetailRepository->create([
                'review_id' => $reviews->id,
                'type_id'   => array_keys($value)[0],
                'rating'    => array_values($value)[0]
            ]);
        }
        $reviews->refresh();
        $reviews = $this->reviewRepository->update(['average_rating' => $reviews->details->avg('rating')], $reviews->id);
        $reviews->refresh();

        return $this->sendResponse($reviews->toArray(), 'Review saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/reviews/{id}",
     *      summary="Display the specified Review",
     *      tags={"Review"},
     *      description="Get Review",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Review",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Review"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Review $review */
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            return $this->sendError('Review not found');
        }

        return $this->sendResponse($review->toArray(), 'Review retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateReviewAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/reviews/{id}",
     *      summary="Update the specified Review in storage",
     *      tags={"Review"},
     *      description="Update Review",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Review",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Review that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/Review")
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Review"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReviewAPIRequest $request)
    {
        $input = $request->all();

        /** @var Review $review */
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            return $this->sendError('Review not found');
        }

        $review = $this->reviewRepository->update($input, $id);

        return $this->sendResponse($review->toArray(), 'Review updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/reviews/{id}",
     *      summary="Remove the specified Review from storage",
     *      tags={"Review"},
     *      description="Delete Review",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Review",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Review $review */
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            return $this->sendError('Review not found');
        }

        $review->delete();
        return $this->sendResponse($id, 'Review deleted successfully');
    }
}
