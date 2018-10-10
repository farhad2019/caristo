<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\RegionalSpecificationDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateRegionalSpecificationRequest;
use App\Http\Requests\Admin\UpdateRegionalSpecificationRequest;
use App\Repositories\Admin\RegionalSpecificationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class RegionalSpecificationController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  RegionalSpecificationRepository */
    private $regionalSpecificationRepository;

    public function __construct(RegionalSpecificationRepository $regionalSpecificationRepo)
    {
        $this->regionalSpecificationRepository = $regionalSpecificationRepo;
        $this->ModelName = 'regionalSpecifications';
        $this->BreadCrumbName = 'RegionalSpecification';
    }

    /**
     * Display a listing of the RegionalSpecification.
     *
     * @param RegionalSpecificationDataTable $regionalSpecificationDataTable
     * @return Response
     */
    public function index(RegionalSpecificationDataTable $regionalSpecificationDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $regionalSpecificationDataTable->render('admin.regional_specifications.index');
    }

    /**
     * Show the form for creating a new RegionalSpecification.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.regional_specifications.create');
    }

    /**
     * Store a newly created RegionalSpecification in storage.
     *
     * @param CreateRegionalSpecificationRequest $request
     *
     * @return Response
     */
    public function store(CreateRegionalSpecificationRequest $request)
    {
        $input = $request->all();

        $regionalSpecification = $this->regionalSpecificationRepository->create($input);

        Flash::success('Regional Specification saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.regionalSpecifications.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.regionalSpecifications.edit', $regionalSpecification->id));
        } else {
            $redirect_to = redirect(route('admin.regionalSpecifications.index'));
        }
        return $redirect_to;
    }

    /**
     * Display the specified RegionalSpecification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $regionalSpecification = $this->regionalSpecificationRepository->findWithoutFail($id);

        if (empty($regionalSpecification)) {
            Flash::error('Regional Specification not found');
            return redirect(route('admin.regionalSpecifications.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $regionalSpecification);
        return view('admin.regional_specifications.show')->with('regionalSpecification', $regionalSpecification);
    }

    /**
     * Show the form for editing the specified RegionalSpecification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $regionalSpecification = $this->regionalSpecificationRepository->findWithoutFail($id);

        if (empty($regionalSpecification)) {
            Flash::error('Regional Specification not found');
            return redirect(route('admin.regionalSpecifications.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $regionalSpecification);
        return view('admin.regional_specifications.edit')->with('regionalSpecification', $regionalSpecification);
    }

    /**
     * Update the specified RegionalSpecification in storage.
     *
     * @param  int $id
     * @param UpdateRegionalSpecificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegionalSpecificationRequest $request)
    {
        $regionalSpecification = $this->regionalSpecificationRepository->findWithoutFail($id);

        if (empty($regionalSpecification)) {
            Flash::error('Regional Specification not found');
            return redirect(route('admin.regionalSpecifications.index'));
        }

        $regionalSpecification = $this->regionalSpecificationRepository->update($request->all(), $id);

        Flash::success('Regional Specification updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.regionalSpecifications.create'));
        } else {
            $redirect_to = redirect(route('admin.regionalSpecifications.index'));
        }
        return $redirect_to;
    }

    /**
     * Remove the specified RegionalSpecification from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $regionalSpecification = $this->regionalSpecificationRepository->findWithoutFail($id);

        if (empty($regionalSpecification)) {
            Flash::error('Regional Specification not found');
            return redirect(route('admin.regionalSpecifications.index'));
        }

        $this->regionalSpecificationRepository->delete($id);

        Flash::success('Regional Specification deleted successfully.');
        return redirect(route('admin.regionalSpecifications.index'));
    }
}