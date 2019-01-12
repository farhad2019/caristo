<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateReviewAspectAPIRequest;
use App\Http\Requests\Api\UpdateReviewAspectAPIRequest;
use App\Models\ReviewAspect;
use App\Repositories\Admin\ReviewAspectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ReviewAspectController
 * @package App\Http\Controllers\Api
 */

class ReviewAspectAPIController extends AppBaseController
{
    /** @var  ReviewAspectRepository */
    private $reviewAspectRepository;

    public function __construct(ReviewAspectRepository $reviewAspectRepo)
    {
        $this->reviewAspectRepository = $reviewAspectRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/reviewAspects",
     *      summary="Get a listing of the ReviewAspects.",
     *      tags={"ReviewAspect"},
     *      description="Get all ReviewAspects",
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
     *                  @SWG\Items(ref="#/definitions/ReviewAspect")
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
        $this->reviewAspectRepository->pushCriteria(new RequestCriteria($request));
        $this->reviewAspectRepository->pushCriteria(new LimitOffsetCriteria($request));
        $reviewAspects = $this->reviewAspectRepository->all();

        return $this->sendResponse($reviewAspects->toArray(), 'Review Aspects retrieved successfully');
    }

    /**
     * @param CreateReviewAspectAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/reviewAspects",
     *      summary="Store a newly created ReviewAspect in storage",
     *      tags={"ReviewAspect"},
     *      description="Store ReviewAspect",
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
     *          name="body",
     *          in="body",
     *          description="ReviewAspect that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/ReviewAspect")
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
     *                  ref="#/definitions/ReviewAspect"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReviewAspectAPIRequest $request)
    {
        $input = $request->all();

        $reviewAspects = $this->reviewAspectRepository->create($input);

        return $this->sendResponse($reviewAspects->toArray(), 'Review Aspect saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/reviewAspects/{id}",
     *      summary="Display the specified ReviewAspect",
     *      tags={"ReviewAspect"},
     *      description="Get ReviewAspect",
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
     *          description="id of ReviewAspect",
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
     *                  ref="#/definitions/ReviewAspect"
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
        /** @var ReviewAspect $reviewAspect */
        $reviewAspect = $this->reviewAspectRepository->findWithoutFail($id);

        if (empty($reviewAspect)) {
            return $this->sendError('Review Aspect not found');
        }

        return $this->sendResponse($reviewAspect->toArray(), 'Review Aspect retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateReviewAspectAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/reviewAspects/{id}",
     *      summary="Update the specified ReviewAspect in storage",
     *      tags={"ReviewAspect"},
     *      description="Update ReviewAspect",
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
     *          description="id of ReviewAspect",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ReviewAspect that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/ReviewAspect")
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
     *                  ref="#/definitions/ReviewAspect"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReviewAspectAPIRequest $request)
    {
        $input = $request->all();

        /** @var ReviewAspect $reviewAspect */
        $reviewAspect = $this->reviewAspectRepository->findWithoutFail($id);

        if (empty($reviewAspect)) {
            return $this->sendError('Review Aspect not found');
        }

        $reviewAspect = $this->reviewAspectRepository->update($input, $id);

        return $this->sendResponse($reviewAspect->toArray(), 'ReviewAspect updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/reviewAspects/{id}",
     *      summary="Remove the specified ReviewAspect from storage",
     *      tags={"ReviewAspect"},
     *      description="Delete ReviewAspect",
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
     *          description="id of ReviewAspect",
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
        /** @var ReviewAspect $reviewAspect */
        $reviewAspect = $this->reviewAspectRepository->findWithoutFail($id);

        if (empty($reviewAspect)) {
            return $this->sendError('Review Aspect not found');
        }

        $reviewAspect->delete();

        return $this->sendResponse($id, 'Review Aspect deleted successfully');
    }
}
