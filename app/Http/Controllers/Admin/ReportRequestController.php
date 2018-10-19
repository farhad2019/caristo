<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ReportRequestDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateReportRequestRequest;
use App\Http\Requests\Admin\UpdateReportRequestRequest;
use App\Repositories\Admin\ReportRequestRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ReportRequestController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ReportRequestRepository */
    private $reportRequestRepository;

    public function __construct(ReportRequestRepository $reportRequestRepo)
    {
        $this->reportRequestRepository = $reportRequestRepo;
        $this->ModelName = 'reportRequests';
        $this->BreadCrumbName = 'ReportRequest';
    }

    /**
     * Display a listing of the ReportRequest.
     *
     * @param ReportRequestDataTable $reportRequestDataTable
     * @return Response
     */
    public function index(ReportRequestDataTable $reportRequestDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $reportRequestDataTable->render('admin.report_requests.index');
    }

    /**
     * Show the form for creating a new ReportRequest.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.report_requests.create');
    }

    /**
     * Store a newly created ReportRequest in storage.
     *
     * @param CreateReportRequestRequest $request
     *
     * @return Response
     */
    public function store(CreateReportRequestRequest $request)
    {
        $input = $request->all();

        $reportRequest = $this->reportRequestRepository->create($input);

        Flash::success('Report Request saved successfully.');

        return redirect(route('admin.reportRequests.index'));
    }

    /**
     * Display the specified ReportRequest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $reportRequest = $this->reportRequestRepository->findWithoutFail($id);

        if (empty($reportRequest)) {
            Flash::error('Report Request not found');

            return redirect(route('admin.reportRequests.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $reportRequest);
        return view('admin.report_requests.show')->with('reportRequest', $reportRequest);
    }

    /**
     * Show the form for editing the specified ReportRequest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reportRequest = $this->reportRequestRepository->findWithoutFail($id);

        if (empty($reportRequest)) {
            Flash::error('Report Request not found');

            return redirect(route('admin.reportRequests.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $reportRequest);
        return view('admin.report_requests.edit')->with('reportRequest', $reportRequest);
    }

    /**
     * Update the specified ReportRequest in storage.
     *
     * @param  int              $id
     * @param UpdateReportRequestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReportRequestRequest $request)
    {
        $reportRequest = $this->reportRequestRepository->findWithoutFail($id);

        if (empty($reportRequest)) {
            Flash::error('Report Request not found');

            return redirect(route('admin.reportRequests.index'));
        }

        $reportRequest = $this->reportRequestRepository->update($request->all(), $id);

        Flash::success('Report Request updated successfully.');

        return redirect(route('admin.reportRequests.index'));
    }

    /**
     * Remove the specified ReportRequest from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reportRequest = $this->reportRequestRepository->findWithoutFail($id);

        if (empty($reportRequest)) {
            Flash::error('Report Request not found');

            return redirect(route('admin.reportRequests.index'));
        }

        $this->reportRequestRepository->delete($id);

        Flash::success('Report Request deleted successfully.');

        return redirect(route('admin.reportRequests.index'));
    }
}
