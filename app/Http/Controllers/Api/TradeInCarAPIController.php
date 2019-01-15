<?php

namespace App\Http\Controllers\Api;

use App\Criteria\TradeInCarCriteria;
use App\Http\Requests\Api\CreateTradeInCarAPIRequest;
use App\Http\Requests\Api\UpdateTradeInCarAPIRequest;
use App\Models\TradeInCar;
use App\Repositories\Admin\TradeInCarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class TradeInCarController
 * @package App\Http\Controllers\Api
 */
class TradeInCarAPIController extends AppBaseController
{
    /** @var  TradeInCarRepository */
    private $tradeInCarRepository;

    public function __construct(TradeInCarRepository $tradeInCarRepo)
    {
        $this->tradeInCarRepository = $tradeInCarRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/tradeInCars",
     *      summary="Get a listing of the TradeInCars.",
     *      tags={"TradeInCar"},
     *      description="Get all TradeInCars",
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
     *      @SWG\Parameter(
     *          name="type",
     *          description="type, 10=tradeIn; 20=evaluate",
     *          type="integer",
     *          default=10,
     *          required=true,
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
     *                  @SWG\Items(ref="#/definitions/TradeInCar")
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
        $this->tradeInCarRepository->pushCriteria(new RequestCriteria($request));
        $this->tradeInCarRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->tradeInCarRepository->pushCriteria(new TradeInCarCriteria($request));
        $tradeInCars = $this->tradeInCarRepository->all();

        return $this->sendResponse($tradeInCars->toArray(), 'Trade In Cars retrieved successfully');
    }

    /**
     * @param CreateTradeInCarAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/tradeInCars",
     *      summary="Store a newly created TradeInCar in storage",
     *      tags={"TradeInCar"},
     *      description="Store TradeInCar",
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
     *          description="TradeInCar that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TradeInCar")
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
     *                  ref="#/definitions/TradeInCar"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTradeInCarAPIRequest $request)
    {
        if ($request->type == TradeInCar::TRADE_IN) {
            $tradeInCarRequest = $this->tradeInCarRepository->findWhere(['owner_car_id' => $request->owner_car_id, 'customer_car_id' => $request->customer_car_id]);
            if ($tradeInCarRequest->count() > 0) {
                return $this->sendResponse([], 'This car has already been traded!');
            }
        }
        if ($request->type == TradeInCar::EVALUATE_CAR) {
            $evaluateCarRequest = $this->tradeInCarRepository->findWhere(['customer_car_id' => $request->customer_car_id, 'type' => $request->type]);
            if ($evaluateCarRequest->count() > 0) {
                return $this->sendResponse([], 'This car has already been requested for evaluation!');
            }
        }

        $tradeInCar = $this->tradeInCarRepository->saveRecord($request);
        return $this->sendResponse($tradeInCar->toArray(), 'Car traded in successful');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/tradeInCars/{id}",
     *      summary="Display the specified TradeInCar",
     *      tags={"TradeInCar"},
     *      description="Get TradeInCar",
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
     *          description="id of TradeInCar",
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
     *                  ref="#/definitions/TradeInCar"
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
        /** @var TradeInCar $tradeInCar */
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);

        if (empty($tradeInCar)) {
            return $this->sendError('Trade In Car not found');
        }

        return $this->sendResponse($tradeInCar->toArray(), 'Trade In Car retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTradeInCarAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/tradeInCars/{id}",
     *      summary="Update the specified TradeInCar in storage",
     *      tags={"TradeInCar"},
     *      description="Update TradeInCar",
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
     *          description="id of TradeInCar",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TradeInCar that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TradeInCar")
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
     *                  ref="#/definitions/TradeInCar"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTradeInCarAPIRequest $request)
    {
        $input = $request->all();

        /** @var TradeInCar $tradeInCar */
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);

        if (empty($tradeInCar)) {
            return $this->sendError('Trade In Car not found');
        }

        $tradeInCar = $this->tradeInCarRepository->update($input, $id);

        return $this->sendResponse($tradeInCar->toArray(), 'TradeInCar updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * @SWG\Delete(
     *      path="/tradeInCars/{id}",
     *      summary="Remove the specified TradeInCar from storage",
     *      tags={"TradeInCar"},
     *      description="Delete TradeInCar",
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
     *          description="id of TradeInCar",
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
        /** @var TradeInCar $tradeInCar */
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);

        if (empty($tradeInCar)) {
            return $this->sendError('Trade In Car not found');
        }

        $tradeInCar->delete();

        return $this->sendResponse($id, 'Trade In Car deleted successfully');
    }
}
