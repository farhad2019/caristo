<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateBidsHistoryAPIRequest;
use App\Http\Requests\Api\UpdateBidsHistoryAPIRequest;
use App\Models\BidsHistory;
use App\Repositories\Admin\BidsHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class BidsHistoryController
 * @package App\Http\Controllers\Api
 */

class BidsHistoryAPIController extends AppBaseController
{
    /** @var  BidsHistoryRepository */
    private $bidsHistoryRepository;

    public function __construct(BidsHistoryRepository $bidsHistoryRepo)
    {
        $this->bidsHistoryRepository = $bidsHistoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/bidsHistories",
     *      summary="Get a listing of the BidsHistories.",
     *      tags={"BidsHistory"},
     *      description="Get all BidsHistories",
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
     *                  @SWG\Items(ref="#/definitions/BidsHistory")
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
        $this->bidsHistoryRepository->pushCriteria(new RequestCriteria($request));
        $this->bidsHistoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $bidsHistories = $this->bidsHistoryRepository->all();

        return $this->sendResponse($bidsHistories->toArray(), 'Bids Histories retrieved successfully');
    }

    /**
     * @param CreateBidsHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/bidsHistories",
     *      summary="Store a newly created BidsHistory in storage",
     *      tags={"BidsHistory"},
     *      description="Store BidsHistory",
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
     *          description="BidsHistory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BidsHistory")
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
     *                  ref="#/definitions/BidsHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBidsHistoryAPIRequest $request)
    {
        $input = $request->all();

        $bidsHistories = $this->bidsHistoryRepository->create($input);

        return $this->sendResponse($bidsHistories->toArray(), 'Bids History saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/bidsHistories/{id}",
     *      summary="Display the specified BidsHistory",
     *      tags={"BidsHistory"},
     *      description="Get BidsHistory",
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
     *          description="id of BidsHistory",
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
     *                  ref="#/definitions/BidsHistory"
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
        /** @var BidsHistory $bidsHistory */
        $bidsHistory = $this->bidsHistoryRepository->findWithoutFail($id);

        if (empty($bidsHistory)) {
            return $this->sendError('Bids History not found');
        }

        return $this->sendResponse($bidsHistory->toArray(), 'Bids History retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBidsHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/bidsHistories/{id}",
     *      summary="Update the specified BidsHistory in storage",
     *      tags={"BidsHistory"},
     *      description="Update BidsHistory",
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
     *          description="id of BidsHistory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BidsHistory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BidsHistory")
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
     *                  ref="#/definitions/BidsHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBidsHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var BidsHistory $bidsHistory */
        $bidsHistory = $this->bidsHistoryRepository->findWithoutFail($id);

        if (empty($bidsHistory)) {
            return $this->sendError('Bids History not found');
        }

        $bidsHistory = $this->bidsHistoryRepository->update($input, $id);

        return $this->sendResponse($bidsHistory->toArray(), 'BidsHistory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * @SWG\Delete(
     *      path="/bidsHistories/{id}",
     *      summary="Remove the specified BidsHistory from storage",
     *      tags={"BidsHistory"},
     *      description="Delete BidsHistory",
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
     *          description="id of BidsHistory",
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
        /** @var BidsHistory $bidsHistory */
        $bidsHistory = $this->bidsHistoryRepository->findWithoutFail($id);

        if (empty($bidsHistory)) {
            return $this->sendError('Bids History not found');
        }

        $bidsHistory->delete();

        return $this->sendResponse($id, 'Bids History deleted successfully');
    }
}
