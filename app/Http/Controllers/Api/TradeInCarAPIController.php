<?php

namespace App\Http\Controllers\Api;

use App\Criteria\TradeInCarCriteria;
use App\Http\Requests\Api\CreateTradeInCarAPIRequest;
use App\Http\Requests\Api\UpdateTradeInCarAPIRequest;
use App\Models\MyCar;
use App\Models\Notification;
use App\Models\TradeInCar;
use App\Repositories\Admin\NotificationRepository;
use App\Repositories\Admin\TradeInCarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(TradeInCarRepository $tradeInCarRepo, NotificationRepository $notificationRepo)
    {
        $this->tradeInCarRepository = $tradeInCarRepo;
        $this->notificationRepository = $notificationRepo;
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateTradeInCarAPIRequest $request)
    {
        $message = '';
        if ($request->type == TradeInCar::TRADE_IN) {
            $tradeInCarRequest = $this->tradeInCarRepository->findWhere(['owner_car_id' => $request->owner_car_id, 'customer_car_id' => $request->customer_car_id]);
            if ($tradeInCarRequest->count() > 0) {
                return $this->sendError('This car has already been traded!');
//                return $this->sendResponse([], 'This car has already been traded!');
            }
            $message = 'Car traded in request post successfully';
        }

        if ($request->type == TradeInCar::EVALUATE_CAR) {
            /*$evaluateCarRequest = $this->tradeInCarRepository->findWhere(['customer_car_id' => $request->customer_car_id, 'type' => $request->type]);
            if ($evaluateCarRequest->count() > 0) {
                return $this->sendError('This car has already been requested for evaluation!');
                return $this->sendResponse([], 'This car has already been requested for evaluation!');
            }*/
            $message = 'Car evaluation request post successfully';
        }

        $tradeInCar = $this->tradeInCarRepository->saveRecord($request);
        $subject = 'New Trade In Request';
        if ($request->type == TradeInCar::TRADE_IN) {
            if ($tradeInCar->myCar->category_id == MyCar::LIMITED_EDITION) {
                foreach ($tradeInCar->myCar->dealers as $dealer) {
                    $name = $dealer->name;
                    $email = $dealer->email;

                    Mail::send('email.notify', ['name' => $name],
                        function ($mail) use ($email, $name, $subject) {
                            $mail->from(getenv('MAIL_FROM_ADDRESS'), "CaristoCrat App");
                            $mail->to($email, $name);
                            $mail->subject($subject);
                        });

                    ################# NOTIFICATION ####################
                    $dealerTradeInCar = $this->tradeInCarRepository->findWhere(['user_id' => $dealer->id, 'owner_car_id' => $tradeInCar->owner_car_id, 'customer_car_id' => $tradeInCar->customer_car_id])->first();

                    $notification = [
                        'sender_id'   => Auth::id(),
                        'action_type' => Notification::NOTIFICATION_TYPE_TRADE_IN,
                        'url'         => null,
                        'ref_id'      => $dealerTradeInCar->id,
                        'message'     => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_TRADE_IN]
                    ];

                    $this->notificationRepository->notification($notification, $dealer->id);
                }
                return $this->sendResponse($tradeInCar->toArray(), $message);
            }

            $user = $tradeInCar->myCar->owner;

            $name = $user->name;
            $email = $user->email;

            Mail::send('email.notify', ['name' => $name],
                function ($mail) use ($email, $name, $subject) {
                    $mail->from(getenv('MAIL_FROM_ADDRESS'), "CaristoCrat App");
                    $mail->to($email, $name);
                    $mail->subject($subject);
                });

            ################# NOTIFICATION ####################
            $notification = [
                'sender_id'   => Auth::id(),
                'action_type' => Notification::NOTIFICATION_TYPE_TRADE_IN,
                'url'         => null,
                'ref_id'      => $tradeInCar->id,
                'message'     => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_TRADE_IN]
            ];
            $this->notificationRepository->notification($notification, $tradeInCar->myCar->owner_id);
        }

        return $this->sendResponse($tradeInCar->toArray(), $message);
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
     * //@SWG\Put(
     *      path="/tradeInCars/{id}",
     *      summary="Update the specified TradeInCar in storage",
     *      tags={"TradeInCar"},
     *      description="Update TradeInCar",
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
     *          description="id of TradeInCar",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TradeInCar that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/TradeInCar")
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
     *                  ref="#/definitions/TradeInCar"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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
     * //@SWG\Delete(
     *      path="/tradeInCars/{id}",
     *      summary="Remove the specified TradeInCar from storage",
     *      tags={"TradeInCar"},
     *      description="Delete TradeInCar",
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
     *          description="id of TradeInCar",
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
        /** @var TradeInCar $tradeInCar */
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);

        if (empty($tradeInCar)) {
            return $this->sendError('Trade In Car not found');
        }

        $tradeInCar->delete();

        return $this->sendResponse($id, 'Trade In Car deleted successfully');
    }
}
