<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateRegionalSpecificationAPIRequest;
use App\Http\Requests\Api\UpdateRegionalSpecificationAPIRequest;
use App\Models\RegionalSpecification;
use App\Repositories\Admin\RegionalSpecificationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class RegionalSpecificationController
 * @package App\Http\Controllers\Api
 */
class RegionalSpecificationAPIController extends AppBaseController
{
    /** @var  RegionalSpecificationRepository */
    private $regionalSpecificationRepository;

    public function __construct(RegionalSpecificationRepository $regionalSpecificationRepo)
    {
        $this->regionalSpecificationRepository = $regionalSpecificationRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/regionalSpecifications",
     *      summary="Get a listing of the RegionalSpecifications.",
     *      tags={"RegionalSpecification"},
     *      description="Get all RegionalSpecifications",
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
     *                  @SWG\Items(ref="#/definitions/RegionalSpecification")
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
        $this->regionalSpecificationRepository->pushCriteria(new RequestCriteria($request));
        $this->regionalSpecificationRepository->pushCriteria(new LimitOffsetCriteria($request));
        $regionalSpecifications = $this->regionalSpecificationRepository->all();

        return $this->sendResponse($regionalSpecifications->toArray(), 'Regional Specifications retrieved successfully');
    }

    /**
     * @param CreateRegionalSpecificationAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/regionalSpecifications",
     *      summary="Store a newly created RegionalSpecification in storage",
     *      tags={"RegionalSpecification"},
     *      description="Store RegionalSpecification",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RegionalSpecification that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/RegionalSpecification")
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
     *                  ref="#/definitions/RegionalSpecification"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRegionalSpecificationAPIRequest $request)
    {
        $input = $request->all();

        $regionalSpecifications = $this->regionalSpecificationRepository->create($input);

        return $this->sendResponse($regionalSpecifications->toArray(), 'Regional Specification saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/regionalSpecifications/{id}",
     *      summary="Display the specified RegionalSpecification",
     *      tags={"RegionalSpecification"},
     *      description="Get RegionalSpecification",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of RegionalSpecification",
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
     *                  ref="#/definitions/RegionalSpecification"
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
        /** @var RegionalSpecification $regionalSpecification */
        $regionalSpecification = $this->regionalSpecificationRepository->findWithoutFail($id);

        if (empty($regionalSpecification)) {
            return $this->sendError('Regional Specification not found');
        }

        return $this->sendResponse($regionalSpecification->toArray(), 'Regional Specification retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRegionalSpecificationAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/regionalSpecifications/{id}",
     *      summary="Update the specified RegionalSpecification in storage",
     *      tags={"RegionalSpecification"},
     *      description="Update RegionalSpecification",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of RegionalSpecification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RegionalSpecification that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/RegionalSpecification")
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
     *                  ref="#/definitions/RegionalSpecification"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRegionalSpecificationAPIRequest $request)
    {
        $input = $request->all();

        /** @var RegionalSpecification $regionalSpecification */
        $regionalSpecification = $this->regionalSpecificationRepository->findWithoutFail($id);

        if (empty($regionalSpecification)) {
            return $this->sendError('Regional Specification not found');
        }

        $regionalSpecification = $this->regionalSpecificationRepository->update($input, $id);

        return $this->sendResponse($regionalSpecification->toArray(), 'RegionalSpecification updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/regionalSpecifications/{id}",
     *      summary="Remove the specified RegionalSpecification from storage",
     *      tags={"RegionalSpecification"},
     *      description="Delete RegionalSpecification",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of RegionalSpecification",
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
        /** @var RegionalSpecification $regionalSpecification */
        $regionalSpecification = $this->regionalSpecificationRepository->findWithoutFail($id);

        if (empty($regionalSpecification)) {
            return $this->sendError('Regional Specification not found');
        }

        $regionalSpecification->delete();

        return $this->sendResponse($id, 'Regional Specification deleted successfully');
    }
}
