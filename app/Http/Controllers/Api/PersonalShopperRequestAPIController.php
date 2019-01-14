<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreatePersonalShopperRequestAPIRequest;
use App\Http\Requests\Api\UpdatePersonalShopperRequestAPIRequest;
use App\Models\PersonalShopperRequest;
use App\Repositories\Admin\PersonalShopperRequestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class PersonalShopperRequestController
 * @package App\Http\Controllers\Api
 */

class PersonalShopperRequestAPIController extends AppBaseController
{
    /** @var  PersonalShopperRequestRepository */
    private $personalShopperRequestRepository;

    public function __construct(PersonalShopperRequestRepository $personalShopperRequestRepo)
    {
        $this->personalShopperRequestRepository = $personalShopperRequestRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/personalShopperRequests",
     *      summary="Get a listing of the PersonalShopperRequests.",
     *      tags={"PersonalShopperRequest"},
     *      description="Get all PersonalShopperRequests",
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
     *                  @SWG\Items(ref="#/definitions/PersonalShopperRequest")
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
        $this->personalShopperRequestRepository->pushCriteria(new RequestCriteria($request));
        $this->personalShopperRequestRepository->pushCriteria(new LimitOffsetCriteria($request));
        $personalShopperRequests = $this->personalShopperRequestRepository->all();

        return $this->sendResponse($personalShopperRequests->toArray(), 'Personal Shopper Requests retrieved successfully');
    }

    /**
     * @param CreatePersonalShopperRequestAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/personalShopperRequests",
     *      summary="Store a newly created PersonalShopperRequest in storage",
     *      tags={"PersonalShopperRequest"},
     *      description="Store PersonalShopperRequest",
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
     *          description="PersonalShopperRequest that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PersonalShopperRequest")
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
     *                  ref="#/definitions/PersonalShopperRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePersonalShopperRequestAPIRequest $request)
    {
        $input = $request->all();

        $personalShopperRequests = $this->personalShopperRequestRepository->create($input);

        return $this->sendResponse($personalShopperRequests->toArray(), 'Personal Shopper Request saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/personalShopperRequests/{id}",
     *      summary="Display the specified PersonalShopperRequest",
     *      tags={"PersonalShopperRequest"},
     *      description="Get PersonalShopperRequest",
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
     *          name="id",
     *          description="id of PersonalShopperRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
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
     *                  ref="#/definitions/PersonalShopperRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var PersonalShopperRequest $personalShopperRequest */
        $personalShopperRequest = $this->personalShopperRequestRepository->findWithoutFail($id);

        if (empty($personalShopperRequest)) {
            return $this->sendError('Personal Shopper Request not found');
        }

        return $this->sendResponse($personalShopperRequest->toArray(), 'Personal Shopper Request retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePersonalShopperRequestAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/personalShopperRequests/{id}",
     *      summary="Update the specified PersonalShopperRequest in storage",
     *      tags={"PersonalShopperRequest"},
     *      description="Update PersonalShopperRequest",
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
     *          name="id",
     *          description="id of PersonalShopperRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PersonalShopperRequest that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PersonalShopperRequest")
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
     *                  ref="#/definitions/PersonalShopperRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePersonalShopperRequestAPIRequest $request)
    {
        $input = $request->all();

        /** @var PersonalShopperRequest $personalShopperRequest */
        $personalShopperRequest = $this->personalShopperRequestRepository->findWithoutFail($id);

        if (empty($personalShopperRequest)) {
            return $this->sendError('Personal Shopper Request not found');
        }

        $personalShopperRequest = $this->personalShopperRequestRepository->update($input, $id);

        return $this->sendResponse($personalShopperRequest->toArray(), 'PersonalShopperRequest updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * @SWG\Delete(
     *      path="/personalShopperRequests/{id}",
     *      summary="Remove the specified PersonalShopperRequest from storage",
     *      tags={"PersonalShopperRequest"},
     *      description="Delete PersonalShopperRequest",
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
     *          name="id",
     *          description="id of PersonalShopperRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
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
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var PersonalShopperRequest $personalShopperRequest */
        $personalShopperRequest = $this->personalShopperRequestRepository->findWithoutFail($id);

        if (empty($personalShopperRequest)) {
            return $this->sendError('Personal Shopper Request not found');
        }

        $personalShopperRequest->delete();

        return $this->sendResponse($id, 'Personal Shopper Request deleted successfully');
    }
}
