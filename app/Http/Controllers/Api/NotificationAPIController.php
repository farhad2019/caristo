<?php

namespace App\Http\Controllers\Api;

use App\Criteria\NotificationCriteria;
use App\Http\Requests\Api\CreateNotificationAPIRequest;
use App\Http\Requests\Api\UpdateNotificationAPIRequest;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Repositories\Admin\MyCarRepository;
use App\Repositories\Admin\NotificationRepository;
use App\Repositories\Admin\TradeInCarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class NotificationController
 * @package App\Http\Controllers\Api
 */
class NotificationAPIController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    /** @var  MyCarRepository */
    private $carRepository;

    /** @var  MyCarRepository */
    private $tradInRepository;

    public function __construct(NotificationRepository $notificationRepo, MyCarRepository $carRepo, TradeInCarRepository $tradInRepo)
    {
        $this->notificationRepository = $notificationRepo;
        $this->carRepository = $carRepo;
        $this->tradInRepository = $tradInRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/notifications",
     *      summary="Get a listing of the Notifications.",
     *      tags={"Notification"},
     *      description="Get all Notifications",
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
     *                  @SWG\Items(ref="#/definitions/Notification")
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
        $this->notificationRepository->pushCriteria(new RequestCriteria($request));
        $this->notificationRepository->pushCriteria(new LimitOffsetCriteria($request));
//        $this->notificationRepository->pushCriteria(new NotificationCriteria($request));

        $notifications = Auth::user()->notificationMaster()->where('notification_users.deleted_at', null)->get();

//        var_dump($notifications->toSql());
//        exit();
//        $notifications = $this->notificationRepository->all();

        $extraData = [];
        if (!empty($notifications)) {
            foreach ($notifications as $notification) {
                //$carData = $this->carRepository->findWithoutFail($notification->ref_id);
                $tradInfo = $this->tradInRepository->findWithoutFail(@$notification->ref_id)->toArray();

                $extraData[] = array_merge(@$notification->toArray(), [
                    'image_url'  => isset($tradInfo['trade_against']['media'][0]) ? @$tradInfo['trade_against']['media'][0]['file_url'] : null,
                    'car_name'   => @$tradInfo['trade_against']['car_model']['name'] . ' ' . @$tradInfo['trade_against']['car_model']['brand']['name'],
                    'model_year' => @$tradInfo['trade_against']['year'],
                    'chassis'    => @$tradInfo['trade_against']['chassis']
                ]);
            }
            NotificationUser::whereIn('notification_id', $notifications->pluck('id')->toArray())->update(['status' => NotificationUser::STATUS_READ]);
            return $this->sendResponse($extraData, 'Notifications retrieved successfully');
        }
    }

    /**
     * @param CreateNotificationAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/notifications",
     *      summary="Store a newly created Notification in storage",
     *      tags={"Notification"},
     *      description="Store Notification",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notification that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/Notification")
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
     *                  ref="#/definitions/Notification"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNotificationAPIRequest $request)
    {
        $input = $request->all();

        $notifications = $this->notificationRepository->create($input);

        return $this->sendResponse($notifications->toArray(), 'Notification saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/notifications/{id}",
     *      summary="Display the specified Notification",
     *      tags={"Notification"},
     *      description="Get Notification",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
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
     *                  ref="#/definitions/Notification"
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
        /** @var Notification $notification */
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        return $this->sendResponse($notification->toArray(), 'Notification retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNotificationAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/notifications/{id}",
     *      summary="Update the specified Notification in storage",
     *      tags={"Notification"},
     *      description="Update Notification",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notification that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/Notification")
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
     *                  ref="#/definitions/Notification"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNotificationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Notification $notification */
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification = $this->notificationRepository->update($input, $id);

        return $this->sendResponse($notification->toArray(), 'Notification updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * @SWG\Delete(
     *      path="/notifications/{id}",
     *      summary="Remove the specified Notification from storage",
     *      tags={"Notification"},
     *      description="Delete Notification",
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
     *          description="id of Notification",
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
        if ($id > 0) {
            $notification = $this->notificationRepository->findWithoutFail($id);

            if (empty($notification)) {
                return $this->sendError('Notification not found');
            }

            $notification->details()->where('user_id', Auth::id())->delete();
            $notification->refresh();
            if ($notification->details->count() == 0) {
                $notification->delete();
            }
        } else {
            $notifications = Auth::user()->notificationMaster;

            if (empty($notifications)) {
                return $this->sendError('Notification not found');
            }

            foreach ($notifications as $notification) {
                $notification->details()->where('user_id', Auth::id())->delete();
                $notification->refresh();
                if ($notification->details->count() == 0) {
                    $notification->delete();
                }
            }
        }

        return $this->sendResponse($id, 'Notification deleted successfully');
    }
}