<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\TradeInCarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateTradeInCarRequest;
use App\Http\Requests\Admin\UpdateTradeInCarRequest;
use App\Repositories\Admin\TradeInCarRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class TradeInCarController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  TradeInCarRepository */
    private $tradeInCarRepository;

    public function __construct(TradeInCarRepository $tradeInCarRepo)
    {
        $this->tradeInCarRepository = $tradeInCarRepo;
        $this->ModelName = 'tradeInCars';
        $this->BreadCrumbName = 'TradeInCar';
    }

    /**
     * Display a listing of the TradeInCar.
     *
     * @param TradeInCarDataTable $tradeInCarDataTable
     * @return Response
     */
    /*public function index(TradeInCarDataTable $tradeInCarDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $tradeInCarDataTable->render('admin.trade_in_cars.index');
    }*/
    public function index(TradeInCarDataTable $tradeInCarDataTable)
    {
        $tradeInRequests = $this->tradeInCarRepository->getTradeInCars();

        if (Auth::user()->hasRole('showroom-owner')) {
            return view('admin.showroom.carsListing')
                ->with([
                    'tradeInRequests' => $tradeInRequests
                ]);
        }
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
        $input = $request->all();

        $tradeInCar = $this->tradeInCarRepository->create($input);

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
            return view('admin.showroom.details')->with([
                //'car'     => $car,
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
        ;
        $tradeInCar = $this->tradeInCarRepository->findWithoutFail($id);
        if (empty($tradeInCar)) {
            Flash::error('Trade In Car not found');
            return redirect(route('admin.tradeInCars.index'));
        }

        $tradeInCar = $this->tradeInCarRepository->updateRecord($request, $tradeInCar);
        Flash::success('Trade In Request successfully.');
        return redirect(route('admin.makeBids.index'));
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
}
