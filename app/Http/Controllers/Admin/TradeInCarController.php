<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\TradeInCarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateTradeInCarRequest;
use App\Http\Requests\Admin\UpdateTradeInCarRequest;
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
     * @return Response
     */
    /*public function index(TradeInCarDataTable $tradeInCarDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $tradeInCarDataTable->render('admin.trade_in_cars.index');
    }*/
    public function index(Request $request, TradeInCarDataTable $tradeInCarDataTable)
    {
        $tradeInRequests = $this->tradeInCarRepository->getTradeInCars(false, $request->all());
//        dd($tradeInRequests);
//dd($tradeInRequests->getBindings(), $tradeInRequests->toSql());
//        if (Auth::user()->hasRole('showroom-owner')) {
            return view('admin.showroom.carsListing')
                ->with([
                    'tradeInRequests' => $tradeInRequests
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
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $tradeInCarDataTable->render('admin.trade_in_cars.index');
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
     */
    public function show($id)
    {
        $tradeInRequest = $this->tradeInCarRepository->findWithoutFail($id);

        if (empty($tradeInRequest)) {
            return json_encode(['fail' => 'Trade In Car not found']);
            /*Flash::error('Trade In Car not found');
            return redirect(route('admin.tradeInCars.index'));*/
        }

        if (Auth::user()->hasRole('showroom-owner')) {
            $this->tradeInCarRepository->update(['status' => 10], $id);
            return view('admin.showroom.details')->with([
                'tradeInRequest' => $tradeInRequest
            ]);
        }
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
     */
    public function update($id, UpdateTradeInCarRequest $request)
    {
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);
        if (empty($tradeInCar)) {
            Flash::error('Trade In Car not found');
            return redirect(route('admin.tradeInCars.index'));
        }

        if ($request->type == TradeInCar::TRADE_IN) {
            $tradeInCar = $this->tradeInCarRepository->updateRecord($request, $tradeInCar);
        } else {
            $tradeInCar = $this->bidRepository->saveRecord($request, $tradeInCar);
        }

        ################# NOTIFICATION ####################
        /*$notification = [
            'sender_id' => Auth::id(),
            'action_type' => Notification::NOTIFICATION_TYPE_NEW_BID,
            'url' => null,
            'ref_id' => $tradeInCar->id,
            'message' => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_NEW_BID]
        ];

        $this->notificationRepository->notification($notification, $tradeInCar->tradeAgainst->owner_id);*/


        Flash::success('Trade In Request successfully.');
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
