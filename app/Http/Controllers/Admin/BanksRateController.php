<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\BanksRateDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateBanksRateRequest;
use App\Http\Requests\Admin\UpdateBanksRateRequest;
use App\Repositories\Admin\BanksRateRepository;
use App\Repositories\Admin\ContactUsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

/**
 * Class BanksRateController
 * @package App\Http\Controllers\Admin
 */
class BanksRateController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  BanksRateRepository */
    private $banksRateRepository;

    /** @var  ContactUsRepository */
    private $contactUsRepository;

    /**
     * BanksRateController constructor.
     * @param BanksRateRepository $banksRateRepo
     * @param ContactUsRepository $contactUsRepository
     */
    public function __construct(BanksRateRepository $banksRateRepo, ContactUsRepository $contactUsRepository)
    {
        $this->banksRateRepository = $banksRateRepo;
        $this->contactUsRepository = $contactUsRepository;
        $this->ModelName = 'banksRates';
        $this->BreadCrumbName = 'Bank Rates';
    }

    /**
     * Display a listing of the BanksRate.
     *
     * @param BanksRateDataTable $banksRateDataTable
     * @return Response
     */
    public function index(BanksRateDataTable $banksRateDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $banksRateDataTable->render('admin.banks_rates.index');
    }

    /**
     * Show the form for creating a new BanksRate.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.banks_rates.create');
    }

    /**
     * Store a newly created BanksRate in storage.
     *
     * @param CreateBanksRateRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateBanksRateRequest $request)
    {
        $input = $request->all();

        //$banksRate = $this->banksRateRepository->create($input);
        $banksRate = $this->banksRateRepository->saveRecord($request);

        Flash::success('Bank Rate saved successfully.');
        return redirect(route('admin.banksRates.index'));
    }

    /**
     * Display the specified BanksRate.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $banksRate = $this->banksRateRepository->findWithoutFail($id);

        if (empty($banksRate)) {
            Flash::error('Bank Rate not found');
            return redirect(route('admin.banksRates.index'));
        }

        $getBankRequest = $this->contactUsRepository->getUserRequest($id);
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $banksRate);
        return view('admin.banks_rates.show')->with([
            'banksRate'      => $banksRate,
            'getBankRequest' => $getBankRequest
        ]);
    }

    /**
     * Show the form for editing the specified BanksRate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $banksRate = $this->banksRateRepository->findWithoutFail($id);

        if (empty($banksRate)) {
            Flash::error('Bank Rate not found');
            return redirect(route('admin.banksRates.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $banksRate);
        return view('admin.banks_rates.edit')->with('banksRate', $banksRate);
    }

    /**
     * Update the specified BanksRate in storage.
     *
     * @param  int $id
     * @param UpdateBanksRateRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateBanksRateRequest $request)
    {
        $banksRate = $this->banksRateRepository->findWithoutFail($id);

        if (empty($banksRate)) {
            Flash::error('Bank Rate not found');
            return redirect(route('admin.banksRates.index'));
        }

        $banksRate = $this->banksRateRepository->update($request->all(), $id);
        $this->banksRateRepository->updateRecord($request, $banksRate);

        Flash::success('Bank Rate updated successfully.');
        return redirect(route('admin.banksRates.index'));
    }

    /**
     * Remove the specified BanksRate from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $banksRate = $this->banksRateRepository->findWithoutFail($id);

        if (empty($banksRate)) {
            Flash::error('Bank Rate not found');
            return redirect(route('admin.banksRates.index'));
        }

        if ($banksRate->requests->count() > 0) {
            Flash::error('This bank has requests. Cannot be deleted');
            return redirect(route('admin.banksRates.index'));
        }

        $this->banksRateRepository->delete($id);
        Flash::success('Bank Rate deleted successfully.');
        return redirect(route('admin.banksRates.index'));
    }
}
