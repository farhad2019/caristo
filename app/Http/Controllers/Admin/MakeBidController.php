<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\BidsForShowroomOwnerCriteria;
use App\Criteria\CarsForBidsFilterCriteria;
use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\MakeBidDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateMakeBidRequest;
use App\Http\Requests\Admin\UpdateMakeBidRequest;
use App\Repositories\Admin\MakeBidRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\MyCarRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class MakeBidController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  MakeBidRepository */
    private $makeBidRepository;

    /** @var  MyCarRepository */
    private $carRepository;

    public function __construct(MakeBidRepository $makeBidRepo, MyCarRepository $carRepo)
    {
        $this->makeBidRepository = $makeBidRepo;
        $this->carRepository = $carRepo;
        $this->ModelName = 'makeBids';
        $this->BreadCrumbName = 'MakeBid';
    }

    /**
     * Display a listing of the MakeBid.
     *
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    /*public function index(MakeBidDataTable $makeBidDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $makeBidDataTable->render('admin.make_bids.index');
    }*/
    public function index(Request $request, MakeBidDataTable $makeBidDataTable)
    {
        $this->carRepository->pushCriteria(new BidsForShowroomOwnerCriteria($request));
        $cars = $this->carRepository->all();
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);

        if (Auth::user()->hasRole('showroom-owner')) {
            return view('admin.showroom.carsListing')->with([
                'cars' => $cars,
//            'bid' => $bid
            ]);
        }
        return $makeBidDataTable->render('admin.make_bids.index');
    }

    /**
     * Show the form for creating a new MakeBid.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.make_bids.create');
    }

    /**
     * Store a newly created MakeBid in storage.
     *
     * @param CreateMakeBidRequest $request
     *
     * @return Response
     */
    public function store(CreateMakeBidRequest $request)
    {
        $makeBid = $this->makeBidRepository->saveRecord($request);

        Flash::success('Make Bid saved successfully.');
        return redirect(route('admin.makeBids.index'));
    }

    /**
     * Display the specified MakeBid.
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
            return redirect(route('admin.makeBids.index'));
        }
        $bid = $this->makeBidRepository->findWhere(['car_id' => $id, 'user_id' => Auth::id()])->first();
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $car);
        if (Auth::user()->hasRole('showroom-owner')) {
            return view('admin.showroom.details')->with([
                'car' => $car,
                'bid' => $bid
            ]);
        }
        return view('admin.make_bids.show')->with([
            'car' => $car,
            'bid' => $bid
        ]);
    }

    /**
     * Show the form for editing the specified MakeBid.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $makeBid = $this->makeBidRepository->findWithoutFail($id);

        if (empty($makeBid)) {
            Flash::error('Make Bid not found');
            return redirect(route('admin.makeBids.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $makeBid);
        return view('admin.make_bids.edit')->with('makeBid', $makeBid);
    }

    /**
     * Update the specified MakeBid in storage.
     *
     * @param  int $id
     * @param UpdateMakeBidRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMakeBidRequest $request)
    {
        $makeBid = $this->makeBidRepository->findWithoutFail($id);
        if (empty($makeBid)) {
            Flash::error('Make Bid not found');
            return redirect(route('admin.makeBids.index'));
        }

        $makeBid = $this->makeBidRepository->update($request->all(), $id);

        Flash::success('Make Bid updated successfully.');
        return redirect(route('admin.makeBids.index'));
    }

    /**
     * Remove the specified MakeBid from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $makeBid = $this->makeBidRepository->findWithoutFail($id);
        if (empty($makeBid)) {
            Flash::error('Make Bid not found');
            return redirect(route('admin.makeBids.index'));
        }

        $this->makeBidRepository->delete($id);

        Flash::success('Make Bid deleted successfully.');
        return redirect(route('admin.makeBids.index'));
    }
}
