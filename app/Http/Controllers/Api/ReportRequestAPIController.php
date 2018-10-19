<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateReportRequestAPIRequest;
use App\Http\Requests\Api\UpdateReportRequestAPIRequest;
use App\Models\ReportRequest;
use App\Repositories\Admin\ReportRequestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ReportRequestController
 * @package App\Http\Controllers\Api
 */
class ReportRequestAPIController extends AppBaseController
{
    /** @var  ReportRequestRepository */
    private $reportRequestRepository;

    public function __construct(ReportRequestRepository $reportRequestRepo)
    {
        $this->reportRequestRepository = $reportRequestRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * //@SWG\Get(
     *      path="/reportRequests",
     *      summary="Get a listing of the ReportRequests.",
     *      tags={"ReportRequest"},
     *      description="Get all ReportRequests",
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
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      //@SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
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
     *                  type="array",
     *                  //@SWG\Items(ref="#/definitions/ReportRequest")
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->reportRequestRepository->pushCriteria(new RequestCriteria($request));
        $this->reportRequestRepository->pushCriteria(new LimitOffsetCriteria($request));
        $reportRequests = $this->reportRequestRepository->all();

        return $this->sendResponse($reportRequests->toArray(), 'Report Requests retrieved successfully');
    }

    /**
     * @param CreateReportRequestAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/reportRequests",
     *      summary="Store a newly created ReportRequest in storage",
     *      tags={"ReportRequest"},
     *      description="Store ReportRequest",
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
     *          description="ReportRequest that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ReportRequest")
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
     *                  ref="#/definitions/ReportRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReportRequestAPIRequest $request)
    {
        $reportRequests = $this->reportRequestRepository->saveRecord($request);

        return $this->sendResponse($reportRequests->toArray(), 'Report Request saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/reportRequests/{id}",
     *      summary="Display the specified ReportRequest",
     *      tags={"ReportRequest"},
     *      description="Get ReportRequest",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of ReportRequest",
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
     *                  ref="#/definitions/ReportRequest"
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
        /** @var ReportRequest $reportRequest */
        $reportRequest = $this->reportRequestRepository->findWithoutFail($id);

        if (empty($reportRequest)) {
            return $this->sendError('Report Request not found');
        }

        return $this->sendResponse($reportRequest->toArray(), 'Report Request retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateReportRequestAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/reportRequests/{id}",
     *      summary="Update the specified ReportRequest in storage",
     *      tags={"ReportRequest"},
     *      description="Update ReportRequest",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of ReportRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ReportRequest that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/ReportRequest")
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
     *                  ref="#/definitions/ReportRequest"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReportRequestAPIRequest $request)
    {
        $input = $request->all();

        /** @var ReportRequest $reportRequest */
        $reportRequest = $this->reportRequestRepository->findWithoutFail($id);

        if (empty($reportRequest)) {
            return $this->sendError('Report Request not found');
        }

        $reportRequest = $this->reportRequestRepository->update($input, $id);

        return $this->sendResponse($reportRequest->toArray(), 'ReportRequest updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/reportRequests/{id}",
     *      summary="Remove the specified ReportRequest from storage",
     *      tags={"ReportRequest"},
     *      description="Delete ReportRequest",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of ReportRequest",
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
        /** @var ReportRequest $reportRequest */
        $reportRequest = $this->reportRequestRepository->findWithoutFail($id);

        if (empty($reportRequest)) {
            return $this->sendError('Report Request not found');
        }

        $reportRequest->delete();

        return $this->sendResponse($id, 'Report Request deleted successfully');
    }
}
