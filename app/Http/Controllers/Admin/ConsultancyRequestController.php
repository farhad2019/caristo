<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ConsultancyRequestDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateConsultancyRequestRequest;
use App\Http\Requests\Admin\UpdateConsultancyRequestRequest;
use App\Repositories\Admin\ConsultancyRequestRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ConsultancyRequestController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ConsultancyRequestRepository */
    private $consultancyRequestRepository;

    public function __construct(ConsultancyRequestRepository $consultancyRequestRepo)
    {
        $this->consultancyRequestRepository = $consultancyRequestRepo;
        $this->ModelName = 'consultancyRequests';
        $this->BreadCrumbName = 'ConsultancyRequest';
    }

    /**
     * Display a listing of the ConsultancyRequest.
     *
     * @param ConsultancyRequestDataTable $consultancyRequestDataTable
     * @return Response
     */
    public function index(ConsultancyRequestDataTable $consultancyRequestDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $consultancyRequestDataTable->render('admin.consultancy_requests.index');
    }

    /**
     * Show the form for creating a new ConsultancyRequest.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.consultancy_requests.create');
    }

    /**
     * Store a newly created ConsultancyRequest in storage.
     *
     * @param CreateConsultancyRequestRequest $request
     *
     * @return Response
     */
    public function store(CreateConsultancyRequestRequest $request)
    {
        $input = $request->all();

        $consultancyRequest = $this->consultancyRequestRepository->create($input);

        Flash::success('Consultancy Request saved successfully.');

        return redirect(route('admin.consultancyRequests.index'));
    }

    /**
     * Display the specified ConsultancyRequest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $consultancyRequest = $this->consultancyRequestRepository->findWithoutFail($id);

        if (empty($consultancyRequest)) {
            Flash::error('Consultancy Request not found');

            return redirect(route('admin.consultancyRequests.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $consultancyRequest);
        return view('admin.consultancy_requests.show')->with('consultancyRequest', $consultancyRequest);
    }

    /**
     * Show the form for editing the specified ConsultancyRequest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $consultancyRequest = $this->consultancyRequestRepository->findWithoutFail($id);

        if (empty($consultancyRequest)) {
            Flash::error('Consultancy Request not found');

            return redirect(route('admin.consultancyRequests.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $consultancyRequest);
        return view('admin.consultancy_requests.edit')->with('consultancyRequest', $consultancyRequest);
    }

    /**
     * Update the specified ConsultancyRequest in storage.
     *
     * @param  int              $id
     * @param UpdateConsultancyRequestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConsultancyRequestRequest $request)
    {
        $consultancyRequest = $this->consultancyRequestRepository->findWithoutFail($id);

        if (empty($consultancyRequest)) {
            Flash::error('Consultancy Request not found');

            return redirect(route('admin.consultancyRequests.index'));
        }

        $consultancyRequest = $this->consultancyRequestRepository->update($request->all(), $id);

        Flash::success('Consultancy Request updated successfully.');

        return redirect(route('admin.consultancyRequests.index'));
    }

    /**
     * Remove the specified ConsultancyRequest from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $consultancyRequest = $this->consultancyRequestRepository->findWithoutFail($id);

        if (empty($consultancyRequest)) {
            Flash::error('Consultancy Request not found');

            return redirect(route('admin.consultancyRequests.index'));
        }

        $this->consultancyRequestRepository->delete($id);

        Flash::success('Consultancy Request deleted successfully.');

        return redirect(route('admin.consultancyRequests.index'));
    }
}
