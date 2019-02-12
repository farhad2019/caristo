<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarVersionDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarVersionRequest;
use App\Http\Requests\Admin\UpdateCarVersionRequest;
use App\Repositories\Admin\CarBrandRepository;
use App\Repositories\Admin\CarModelRepository;
use App\Repositories\Admin\CarVersionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class CarVersionController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarVersionRepository */
    private $carVersionRepository;

    /** @var  CarBrandRepository */
    private $brandRepository;

    /** @var  CarModelRepository */
    private $modelRepository;

    public function __construct(CarVersionRepository $carVersionRepo, CarBrandRepository $brandRepo, CarModelRepository $modelRepo)
    {
        $this->carVersionRepository = $carVersionRepo;
        $this->brandRepository = $brandRepo;
        $this->modelRepository = $modelRepo;
        $this->ModelName = 'carVersions';
        $this->BreadCrumbName = 'CarVersion';
    }

    /**
     * Display a listing of the CarVersion.
     *
     * @param CarVersionDataTable $carVersionDataTable
     * @return Response
     */
    public function index(CarVersionDataTable $carVersionDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $carVersionDataTable->render('admin.car_versions.index');
    }

    /**
     * Show the form for creating a new CarVersion.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $brands = $this->brandRepository->all()->pluck('name', 'id')->toArray();
        $carModels = $this->modelRepository->all()->pluck('name', 'id')->toArray();

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.car_versions.create')->with([
            'brands'    => $brands,
            'carModels' => $carModels
        ]);
    }

    /**
     * Store a newly created CarVersion in storage.
     *
     * @param CreateCarVersionRequest $request
     *
     * @return Response
     */
    public function store(CreateCarVersionRequest $request)
    {
        $carVersion = $this->carVersionRepository->saveRecord($request);

        Flash::success('Car Version saved successfully.');
        return redirect(route('admin.carVersions.index'));
    }

    /**
     * Display the specified CarVersion.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $carVersion = $this->carVersionRepository->findWithoutFail($id);

        if (empty($carVersion)) {
            Flash::error('Car Version not found');
            return redirect(route('admin.carVersions.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carVersion);
        return view('admin.car_versions.show')->with('carVersion', $carVersion);
    }

    /**
     * Show the form for editing the specified CarVersion.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $carVersion = $this->carVersionRepository->findWithoutFail($id);

        if (empty($carVersion)) {
            Flash::error('Car Version not found');
            return redirect(route('admin.carVersions.index'));
        }

        $brands = $this->brandRepository->all()->pluck('name', 'id')->toArray();
        $carModels = $this->modelRepository->all()->pluck('name', 'id')->toArray();

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carVersion);
        return view('admin.car_versions.edit')->with([
            'carVersion' => $carVersion,
            'brands'     => $brands,
            'carModels'  => $carModels
        ]);
    }

    /**
     * Update the specified CarVersion in storage.
     *
     * @param  int $id
     * @param UpdateCarVersionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarVersionRequest $request)
    {
        $carVersion = $this->carVersionRepository->findWithoutFail($id);

        if (empty($carVersion)) {
            Flash::error('Car Version not found');
            return redirect(route('admin.carVersions.index'));
        }

        $carVersion = $this->carVersionRepository->update($request->all(), $id);
        Flash::success('Car Version updated successfully.');
        return redirect(route('admin.carVersions.index'));
    }

    /**
     * Remove the specified CarVersion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carVersion = $this->carVersionRepository->findWithoutFail($id);

        if (empty($carVersion)) {
            Flash::error('Car Version not found');
            return redirect(route('admin.carVersions.index'));
        }

        $this->carVersionRepository->delete($id);
        Flash::success('Car Version deleted successfully.');
        return redirect(route('admin.carVersions.index'));
    }
}
