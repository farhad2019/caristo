<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateCarInteractionAPIRequest;
use App\Http\Requests\Api\UpdateCarInteractionAPIRequest;
use App\Models\CarInteraction;
use App\Repositories\Admin\CarInteractionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class CarInteractionController
 * @package App\Http\Controllers\Api
 */
class CarInteractionAPIController extends AppBaseController
{
    /** @var  CarInteractionRepository */
    private $carInteractionRepository;

    public function __construct(CarInteractionRepository $carInteractionRepo)
    {
        $this->carInteractionRepository = $carInteractionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/carInteractions",
     *      summary="Get a listing of the CarInteractions.",
     *      tags={"CarInteraction"},
     *      description="Get all CarInteractions",
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
     *                  @SWG\Items(ref="#/definitions/CarInteraction")
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
        $this->carInteractionRepository->pushCriteria(new RequestCriteria($request));
        $this->carInteractionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $carInteractions = $this->carInteractionRepository->all();

        return $this->sendResponse($carInteractions->toArray(), 'Car Interactions retrieved successfully');
    }

    /**
     * @param CreateCarInteractionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/carInteractions",
     *      summary="Store a newly created CarInteraction in storage",
     *      tags={"CarInteraction"},
     *      description="Store CarInteraction",
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
     *          description="CarInteraction that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CarInteraction")
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
     *                  ref="#/definitions/CarInteraction"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCarInteractionAPIRequest $request)
    {
        $input = $request->all();

        $carInteractions = $this->carInteractionRepository->createRecord($input);

        return $this->sendResponse($carInteractions, 'Car Interaction saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/carInteractions/{id}",
     *      summary="Display the specified CarInteraction",
     *      tags={"CarInteraction"},
     *      description="Get CarInteraction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CarInteraction",
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
     *                  ref="#/definitions/CarInteraction"
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
        /** @var CarInteraction $carInteraction */
        $carInteraction = $this->carInteractionRepository->findWithoutFail($id);
        if (empty($carInteraction)) {
            return $this->sendError('Car Interaction not found');
        }

        return $this->sendResponse($carInteraction->toArray(), 'Car Interaction retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCarInteractionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/carInteractions/{id}",
     *      summary="Update the specified CarInteraction in storage",
     *      tags={"CarInteraction"},
     *      description="Update CarInteraction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CarInteraction",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarInteraction that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CarInteraction")
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
     *                  ref="#/definitions/CarInteraction"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCarInteractionAPIRequest $request)
    {
        $input = $request->all();

        /** @var CarInteraction $carInteraction */
        $carInteraction = $this->carInteractionRepository->findWithoutFail($id);

        if (empty($carInteraction)) {
            return $this->sendError('Car Interaction not found');
        }

        $carInteraction = $this->carInteractionRepository->update($input, $id);

        return $this->sendResponse($carInteraction->toArray(), 'CarInteraction updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * @SWG\Delete(
     *      path="/carInteractions/{id}",
     *      summary="Remove the specified CarInteraction from storage",
     *      tags={"CarInteraction"},
     *      description="Delete CarInteraction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CarInteraction",
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
        /** @var CarInteraction $carInteraction */
        $carInteraction = $this->carInteractionRepository->findWithoutFail($id);

        if (empty($carInteraction)) {
            return $this->sendError('Car Interaction not found');
        }

        $carInteraction->delete();

        return $this->sendResponse($id, 'Car Interaction deleted successfully');
    }
}
