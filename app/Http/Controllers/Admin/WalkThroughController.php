<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\WalkThroughDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\CreateWalkThroughRequest;
use App\Http\Requests\Admin\UpdateWalkThroughRequest;
use App\Repositories\Admin\WalkThroughRepository;
use Flash;
use Response;

class WalkThroughController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  WalkThroughRepository */
    private $walkThroughRepository;

    public function __construct(WalkThroughRepository $walkThroughRepo)
    {
        $this->walkThroughRepository = $walkThroughRepo;
        $this->ModelName = 'walkThroughs';
        $this->BreadCrumbName = 'WalkThrough';
    }

    /**
     * Display a listing of the WalkThrough.
     *
     * @param WalkThroughDataTable $walkThroughDataTable
     * @return Response
     */
    public function index(WalkThroughDataTable $walkThroughDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $walkThroughDataTable->render('admin.walk_throughs.index');
    }

    /**
     * Show the form for creating a new WalkThrough.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.walk_throughs.create');
    }

    /**
     * Store a newly created WalkThrough in storage.
     *
     * @param CreateWalkThroughRequest $request
     *
     * @return Response
     */
    public function store(CreateWalkThroughRequest $request)
    {
        $input = $request->all();

        $walkThrough = $this->walkThroughRepository->create($input);

        Flash::success('Walk Through saved successfully.');

        return redirect(route('admin.walkThroughs.index'));
    }

    /**
     * Display the specified WalkThrough.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);

        if (empty($walkThrough)) {
            Flash::error('Walk Through not found');

            return redirect(route('admin.walkThroughs.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $walkThrough);
        return view('admin.walk_throughs.show')->with('walkThrough', $walkThrough);
    }

    /**
     * Show the form for editing the specified WalkThrough.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);

        if (empty($walkThrough)) {
            Flash::error('Walk Through not found');

            return redirect(route('admin.walkThroughs.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $walkThrough);
        return view('admin.walk_throughs.edit')->with('walkThrough', $walkThrough);
    }

    /**
     * Update the specified WalkThrough in storage.
     *
     * @param  int $id
     * @param UpdateWalkThroughRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWalkThroughRequest $request)
    {
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);

        if (empty($walkThrough)) {
            Flash::error('Walk Through not found');

            return redirect(route('admin.walkThroughs.index'));
        }

        $walkThrough = $this->walkThroughRepository->update($request->all(), $id);

        Flash::success('Walk Through updated successfully.');

        return redirect(route('admin.walkThroughs.index'));
    }

    /**
     * Remove the specified WalkThrough from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);

        if (empty($walkThrough)) {
            Flash::error('Walk Through not found');

            return redirect(route('admin.walkThroughs.index'));
        }

        $this->walkThroughRepository->delete($id);

        Flash::success('Walk Through deleted successfully.');

        return redirect(route('admin.walkThroughs.index'));
    }
}
