<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateConsultancyRequestAPIRequest;
use App\Http\Requests\Api\UpdateConsultancyRequestAPIRequest;
use App\Models\ConsultancyRequest;
use App\Repositories\Admin\ConsultancyRequestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ConsultancyRequestController
 * @package App\Http\Controllers\Api
 */

class ConsultancyRequestAPIController extends AppBaseController
{
    /** @var  ConsultancyRequestRepository */
    private $consultancyRequestRepository;

    public function __construct(ConsultancyRequestRepository $consultancyRequestRepo)
    {
        $this->consultancyRequestRepository = $consultancyRequestRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * //@SWG\Get(
     *      path="/consultancyRequests",
     *      summary="Get a listing of the ConsultancyRequests.",
     *      tags={"ConsultancyRequest"},
     *      description="Get all ConsultancyRequests",
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
     *                  //@SWG\Items(ref="#/definitions/ConsultancyRequest")
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
        $this->consultancyRequestRepository->pushCriteria(new RequestCriteria($request));
        $this->consultancyRequestRepository->pushCriteria(new LimitOffsetCriteria($request));
        $consultancyRequests = $this->consultancyRequestRepository->all();

        return $this->sendResponse($consultancyRequests->toArray(), 'Consultancy Requests retrieved successfully');
    }

    /**
     * @param CreateConsultancyRequestAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/consultancyRequests",
     *      summary="Store a newly created ConsultancyRequest in storage",
     *      tags={"ConsultancyRequest"},
     *      description="Store ConsultancyRequest",
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
     *          description="ConsultancyRequest that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/ConsultancyRequest")
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
     *                  ref="#/definitions/ConsultancyRequest"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateConsultancyRequestAPIRequest $request)
    {
        $input = $request->all();

        $consultancyRequests = $this->consultancyRequestRepository->create($input);

        return $this->sendResponse($consultancyRequests->toArray(), 'Consultancy Request saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/consultancyRequests/{id}",
     *      summary="Display the specified ConsultancyRequest",
     *      tags={"ConsultancyRequest"},
     *      description="Get ConsultancyRequest",
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
     *          description="id of ConsultancyRequest",
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
     *                  ref="#/definitions/ConsultancyRequest"
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
        /** @var ConsultancyRequest $consultancyRequest */
        $consultancyRequest = $this->consultancyRequestRepository->findWithoutFail($id);

        if (empty($consultancyRequest)) {
            return $this->sendError('Consultancy Request not found');
        }

        return $this->sendResponse($consultancyRequest->toArray(), 'Consultancy Request retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateConsultancyRequestAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/consultancyRequests/{id}",
     *      summary="Update the specified ConsultancyRequest in storage",
     *      tags={"ConsultancyRequest"},
     *      description="Update ConsultancyRequest",
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
     *          description="id of ConsultancyRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ConsultancyRequest that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/ConsultancyRequest")
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
     *                  ref="#/definitions/ConsultancyRequest"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateConsultancyRequestAPIRequest $request)
    {
        $input = $request->all();

        /** @var ConsultancyRequest $consultancyRequest */
        $consultancyRequest = $this->consultancyRequestRepository->findWithoutFail($id);

        if (empty($consultancyRequest)) {
            return $this->sendError('Consultancy Request not found');
        }

        $consultancyRequest = $this->consultancyRequestRepository->update($input, $id);

        return $this->sendResponse($consultancyRequest->toArray(), 'ConsultancyRequest updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/consultancyRequests/{id}",
     *      summary="Remove the specified ConsultancyRequest from storage",
     *      tags={"ConsultancyRequest"},
     *      description="Delete ConsultancyRequest",
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
     *          description="id of ConsultancyRequest",
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
        /** @var ConsultancyRequest $consultancyRequest */
        $consultancyRequest = $this->consultancyRequestRepository->findWithoutFail($id);

        if (empty($consultancyRequest)) {
            return $this->sendError('Consultancy Request not found');
        }

        $consultancyRequest->delete();

        return $this->sendResponse($id, 'Consultancy Request deleted successfully');
    }
}
