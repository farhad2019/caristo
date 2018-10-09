<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateEngineTypeAPIRequest;
use App\Http\Requests\Api\UpdateEngineTypeAPIRequest;
use App\Models\EngineType;
use App\Repositories\Admin\EngineTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class EngineTypeController
 * @package App\Http\Controllers\Api
 */
class EngineTypeAPIController extends AppBaseController
{
    /** @var  EngineTypeRepository */
    private $engineTypeRepository;

    public function __construct(EngineTypeRepository $engineTypeRepo)
    {
        $this->engineTypeRepository = $engineTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/engineTypes",
     *      summary="Get a listing of the EngineTypes.",
     *      tags={"EngineType"},
     *      description="Get all EngineTypes",
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
     *          name="locale",
     *          description="Change the locale.",
     *          default="en",
     *          type="string",
     *          required=false,
     *          in="query"
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
     *                  @SWG\Items(ref="#/definitions/EngineType")
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
        \App::setLocale($request->get('locale', 'en'));
        $this->engineTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->engineTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $engineTypes = $this->engineTypeRepository->all();

        return $this->sendResponse($engineTypes->toArray(), 'Engine Types retrieved successfully');
    }

    /**
     * @param CreateEngineTypeAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/engineTypes",
     *      summary="Store a newly created EngineType in storage",
     *      tags={"EngineType"},
     *      description="Store EngineType",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EngineType that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/EngineType")
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
     *                  ref="#/definitions/EngineType"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEngineTypeAPIRequest $request)
    {
        $input = $request->all();

        $engineTypes = $this->engineTypeRepository->create($input);

        return $this->sendResponse($engineTypes->toArray(), 'Engine Type saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/engineTypes/{id}",
     *      summary="Display the specified EngineType",
     *      tags={"EngineType"},
     *      description="Get EngineType",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of EngineType",
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
     *                  ref="#/definitions/EngineType"
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
        /** @var EngineType $engineType */
        $engineType = $this->engineTypeRepository->findWithoutFail($id);

        if (empty($engineType)) {
            return $this->sendError('Engine Type not found');
        }

        return $this->sendResponse($engineType->toArray(), 'Engine Type retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEngineTypeAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/engineTypes/{id}",
     *      summary="Update the specified EngineType in storage",
     *      tags={"EngineType"},
     *      description="Update EngineType",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of EngineType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EngineType that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/EngineType")
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
     *                  ref="#/definitions/EngineType"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEngineTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var EngineType $engineType */
        $engineType = $this->engineTypeRepository->findWithoutFail($id);

        if (empty($engineType)) {
            return $this->sendError('Engine Type not found');
        }

        $engineType = $this->engineTypeRepository->update($input, $id);

        return $this->sendResponse($engineType->toArray(), 'EngineType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Delete(
     *      path="/engineTypes/{id}",
     *      summary="Remove the specified EngineType from storage",
     *      tags={"EngineType"},
     *      description="Delete EngineType",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of EngineType",
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
        /** @var EngineType $engineType */
        $engineType = $this->engineTypeRepository->findWithoutFail($id);

        if (empty($engineType)) {
            return $this->sendError('Engine Type not found');
        }

        $engineType->delete();

        return $this->sendResponse($id, 'Engine Type deleted successfully');
    }
}
