<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\TradeInCarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateTradeInCarRequest;
use App\Http\Requests\Admin\UpdateTradeInCarRequest;
use App\Models\NotificationUser;
use App\Models\TradeInCar;
use App\Repositories\Admin\CarEvaluationBidRepository;
use App\Repositories\Admin\TradeInCarRepository;
use App\Repositories\Admin\NotificationRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use App\Models\Notification;

class TradeInCarController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  TradeInCarRepository */
    private $tradeInCarRepository;

    /** @var  NotificationRepository */
    private $notificationRepository;

    /** @var  CarEvaluationBidRepository */
    private $bidRepository;

    /**
     * TradeInCarController constructor.
     * @param NotificationRepository $notificationRepo
     * @param TradeInCarRepository $tradeInCarRepo
     * @param CarEvaluationBidRepository $bidRepo
     */
    public function __construct(NotificationRepository $notificationRepo, TradeInCarRepository $tradeInCarRepo, CarEvaluationBidRepository $bidRepo)
    {
        $this->tradeInCarRepository = $tradeInCarRepo;
        $this->notificationRepository = $notificationRepo;
        $this->bidRepository = $bidRepo;
        $this->ModelName = 'tradeInCars';
        $this->BreadCrumbName = 'TradeInCar';
    }

    /**
     * Display a listing of the TradeInCar.
     *
     * @param Request $request
     * @param TradeInCarDataTable $tradeInCarDataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /*public function index(TradeInCarDataTable $tradeInCarDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $tradeInCarDataTable->render('admin.trade_in_cars.index');
    }*/
    public function index(Request $request, TradeInCarDataTable $tradeInCarDataTable)
    {
        $tradeInRequests = $this->tradeInCarRepository->getTradeInCars(false, $request->all());
        $notifications = Auth::user()->notifications()->where('status', NotificationUser::STATUS_DELIVERED)->get();

        /*dd($tradeInRequests);
        dd($tradeInRequests->getBindings(), $tradeInRequests->toSql());
        if (Auth::user()->hasRole('showroom-owner')) {*/
        return view('admin.showroom.carsListing')
            ->with([
                'tradeInRequests' => $tradeInRequests,
                'notifications'   => $notifications
            ]);
//        }
//        $myCars = Auth::user()->cars()->whereHas('myTradeCars', function ($cars) {
//            return $cars->whereRaw('amount IS NOT NULL');
//        })->get();
//
//        if (Auth::user()->hasRole('showroom-owner')) {
//            return view('admin.showroom.bidsHistoryListing')->with([
//                'cars' => $myCars,
////            'bid' => $bid
//            ]);
//        }
//        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
//        return $tradeInCarDataTable->render('admin.trade_in_cars.index');
    }

    /**
     * Show the form for creating a new TradeInCar.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.trade_in_cars.create');
    }

    /**
     * Store a newly created TradeInCar in storage.
     *
     * @param CreateTradeInCarRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateTradeInCarRequest $request)
    {
        if ($request->type == TradeInCar::TRADE_IN) {
            $tradeInCar = $this->tradeInCarRepository->saveRecord($request);
        } else {

        }

        Flash::success('Trade In Car saved successfully.');
        return redirect(route('admin.tradeInCars.index'));
    }

    /**
     * Display the specified TradeInCar.
     *
     * @param  int $id
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function show($id)
    {
        $tradeInRequest = $this->tradeInCarRepository->findWithoutFail($id);

        if (empty($tradeInRequest)) {
            return json_encode(['fail' => 'Trade In Car not found']);
            /*Flash::error('Trade In Car not found');
            return redirect(route('admin.tradeInCars.index'));*/
        }

//        if (Auth::user()->hasRole('showroom-owner')) {
        $this->tradeInCarRepository->update(['status' => 10], $id);
        $notificationIds = $this->notificationRepository->findWhere(['ref_id' => $id])->pluck('id');
//        NotificationUser::where('notification_id', $notification->id)->update(['status' => NotificationUser::STATUS_READ]);
        Auth::user()->notifications()->whereIn('notification_id', $notificationIds)->update(['status' => NotificationUser::STATUS_READ]);
        return view('admin.showroom.details')->with([
            'tradeInRequest' => $tradeInRequest
        ]);
//        }
//        return json_encode(['success' => $tradeInRequest]);
        /*BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $tradeInCar);
        return view('admin.trade_in_cars.show')->with('tradeInCar', $tradeInCar);*/
    }

    /**
     * Show the form for editing the specified TradeInCar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);

        if (empty($tradeInCar)) {
            Flash::error('Trade In Car not found');

            return redirect(route('admin.tradeInCars.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $tradeInCar);
        return view('admin.trade_in_cars.edit')->with('tradeInCar', $tradeInCar);
    }

    /**
     * Update the specified TradeInCar in storage.
     *
     * @param  int $id
     * @param UpdateTradeInCarRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateTradeInCarRequest $request)
    {
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);
        if (empty($tradeInCar)) {
            Flash::error('Trade In Car not found');
            return redirect(route('admin.tradeInCars.index'));
        }

        $this->tradeInCarRepository->update(['updated_at' => Carbon::now()->format('Y-m-d H:i:s')], $id);
        $this->bidRepository->saveRecord($request, $tradeInCar);

        if ($request->type == TradeInCar::TRADE_IN) {
            //$tradeInCar = $this->tradeInCarRepository->updateRecord($request, $tradeInCar);
            Flash::success('Bid on trade in request has been submitted successfully');
            $notification_type = Notification::NOTIFICATION_TYPE_TRADE_IN_NEW_BID;

            ################# NOTIFICATION ####################
            $notification = [
                'sender_id'   => Auth::id(),
                'action_type' => $notification_type,
                'url'         => null,
                'ref_id'      => $tradeInCar->id,
                'message'     => Notification::$NOTIFICATION_MESSAGE[$notification_type]
            ];

            $this->notificationRepository->notification($notification, $tradeInCar->tradeAgainst->owner_id);
        } else {
//            $this->tradeInCarRepository->update(['updated_at' => Carbon::now()->format('Y-m-d H:i:s')], $id);
//            $this->bidRepository->saveRecord($request, $tradeInCar);
            Flash::success('Bid on evaluation request has been submitted successfully');
            //$notification_type = Notification::NOTIFICATION_TYPE_EVALUATION_NEW_BID;
        }

        return redirect(route('admin.tradeInCars.index'));
    }

    /**
     * Remove the specified TradeInCar from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);

        if (empty($tradeInCar)) {
            Flash::error('Trade In Car not found');

            return redirect(route('admin.tradeInCars.index'));
        }

        $this->tradeInCarRepository->delete($id);

        Flash::success('Trade In Car deleted successfully.');

        return redirect(route('admin.tradeInCars.index'));
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        $tradeInRequestsCount = $this->tradeInCarRepository->getTradeInCars(false, [], 20)->count();
        return $tradeInRequestsCount;
    }
}
