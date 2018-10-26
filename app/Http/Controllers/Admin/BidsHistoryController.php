<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\BidsHistoryDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateBidsHistoryRequest;
use App\Http\Requests\Admin\UpdateBidsHistoryRequest;
use App\Repositories\Admin\BidsHistoryRepository;
use App\Repositories\Admin\MakeBidRepository;
use App\Repositories\Admin\MyCarRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

class BidsHistoryController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  BidsHistoryRepository */
    private $bidsHistoryRepository;

    /** @var  MyCarRepository */
    private $carRepository;

    /** @var  MakeBidRepository */
    private $makeBidRepository;

    public function __construct(BidsHistoryRepository $bidsHistoryRepo, MyCarRepository $carRepo, MakeBidRepository $makeBidRepo)
    {
        $this->bidsHistoryRepository = $bidsHistoryRepo;
        $this->carRepository = $carRepo;
        $this->makeBidRepository = $makeBidRepo;
        $this->ModelName = 'bidsHistories';
        $this->BreadCrumbName = 'BidsHistory';
    }

    /**
     * Display a listing of the BidsHistory.
     *
     * @param BidsHistoryDataTable $bidsHistoryDataTable
     * @return Response
     */
    public function index(BidsHistoryDataTable $bidsHistoryDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $bidsHistoryDataTable->render('admin.bids_histories.index');
    }

    /**
     * Show the form for creating a new BidsHistory.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.bids_histories.create');
    }

    /**
     * Store a newly created BidsHistory in storage.
     *
     * @param CreateBidsHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreateBidsHistoryRequest $request)
    {
        $input = $request->all();

        $bidsHistory = $this->bidsHistoryRepository->create($input);

        Flash::success('Bids History saved successfully.');

        return redirect(route('admin.bidsHistories.index'));
    }

    /**
     * Display the specified BidsHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $car = $this->carRepository->findWithoutFail($id);

        if (empty($car)) {
            Flash::error('Make Bid not found');
            return redirect(route('admin.bidsHistories.index'));
        }
        $bid = $this->makeBidRepository->findWhere(['car_id' => $id, 'user_id' => Auth::id()])->first();

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $car);
        return view('admin.bids_histories.show')->with([
            'car' => $car,
            'bid' => $bid
        ]);
    }

    /**
     * Show the form for editing the specified BidsHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bidsHistory = $this->bidsHistoryRepository->findWithoutFail($id);

        if (empty($bidsHistory)) {
            Flash::error('Bids History not found');

            return redirect(route('admin.bidsHistories.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $bidsHistory);
        return view('admin.bids_histories.edit')->with('bidsHistory', $bidsHistory);
    }

    /**
     * Update the specified BidsHistory in storage.
     *
     * @param  int $id
     * @param UpdateBidsHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBidsHistoryRequest $request)
    {
        $bidsHistory = $this->bidsHistoryRepository->findWithoutFail($id);

        if (empty($bidsHistory)) {
            Flash::error('Bids History not found');

            return redirect(route('admin.bidsHistories.index'));
        }

        $bidsHistory = $this->bidsHistoryRepository->update($request->all(), $id);

        Flash::success('Bids History updated successfully.');

        return redirect(route('admin.bidsHistories.index'));
    }

    /**
     * Remove the specified BidsHistory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bidsHistory = $this->bidsHistoryRepository->findWithoutFail($id);

        if (empty($bidsHistory)) {
            Flash::error('Bids History not found');

            return redirect(route('admin.bidsHistories.index'));
        }

        $this->bidsHistoryRepository->delete($id);

        Flash::success('Bids History deleted successfully.');

        return redirect(route('admin.bidsHistories.index'));
    }
}
