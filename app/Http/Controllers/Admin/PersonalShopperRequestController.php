<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\PersonalShopperRequestDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreatePersonalShopperRequestRequest;
use App\Http\Requests\Admin\UpdatePersonalShopperRequestRequest;
use App\Repositories\Admin\PersonalShopperRequestRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PersonalShopperRequestController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  PersonalShopperRequestRepository */
    private $personalShopperRequestRepository;

    public function __construct(PersonalShopperRequestRepository $personalShopperRequestRepo)
    {
        $this->personalShopperRequestRepository = $personalShopperRequestRepo;
        $this->ModelName = 'personalShopperRequests';
        $this->BreadCrumbName = 'PersonalShopperRequest';
    }

    /**
     * Display a listing of the PersonalShopperRequest.
     *
     * @param PersonalShopperRequestDataTable $personalShopperRequestDataTable
     * @return Response
     */
    public function index(PersonalShopperRequestDataTable $personalShopperRequestDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $personalShopperRequestDataTable->render('admin.personal_shopper_requests.index');
    }

    /**
     * Show the form for creating a new PersonalShopperRequest.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.personal_shopper_requests.create');
    }

    /**
     * Store a newly created PersonalShopperRequest in storage.
     *
     * @param CreatePersonalShopperRequestRequest $request
     *
     * @return Response
     */
    public function store(CreatePersonalShopperRequestRequest $request)
    {
        $input = $request->all();

        $personalShopperRequest = $this->personalShopperRequestRepository->create($input);

        Flash::success('Personal Shopper Request saved successfully.');

        return redirect(route('admin.personalShopperRequests.index'));
    }

    /**
     * Display the specified PersonalShopperRequest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $personalShopperRequest = $this->personalShopperRequestRepository->findWithoutFail($id);

        if (empty($personalShopperRequest)) {
            Flash::error('Personal Shopper Request not found');

            return redirect(route('admin.personalShopperRequests.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $personalShopperRequest);
        return view('admin.personal_shopper_requests.show')->with('personalShopperRequest', $personalShopperRequest);
    }

    /**
     * Show the form for editing the specified PersonalShopperRequest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $personalShopperRequest = $this->personalShopperRequestRepository->findWithoutFail($id);

        if (empty($personalShopperRequest)) {
            Flash::error('Personal Shopper Request not found');

            return redirect(route('admin.personalShopperRequests.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $personalShopperRequest);
        return view('admin.personal_shopper_requests.edit')->with('personalShopperRequest', $personalShopperRequest);
    }

    /**
     * Update the specified PersonalShopperRequest in storage.
     *
     * @param  int              $id
     * @param UpdatePersonalShopperRequestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePersonalShopperRequestRequest $request)
    {
        $personalShopperRequest = $this->personalShopperRequestRepository->findWithoutFail($id);

        if (empty($personalShopperRequest)) {
            Flash::error('Personal Shopper Request not found');

            return redirect(route('admin.personalShopperRequests.index'));
        }

        $personalShopperRequest = $this->personalShopperRequestRepository->update($request->all(), $id);

        Flash::success('Personal Shopper Request updated successfully.');

        return redirect(route('admin.personalShopperRequests.index'));
    }

    /**
     * Remove the specified PersonalShopperRequest from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $personalShopperRequest = $this->personalShopperRequestRepository->findWithoutFail($id);

        if (empty($personalShopperRequest)) {
            Flash::error('Personal Shopper Request not found');

            return redirect(route('admin.personalShopperRequests.index'));
        }

        $this->personalShopperRequestRepository->delete($id);

        Flash::success('Personal Shopper Request deleted successfully.');

        return redirect(route('admin.personalShopperRequests.index'));
    }
}
