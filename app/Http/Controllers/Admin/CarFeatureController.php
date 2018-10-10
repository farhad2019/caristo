<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarFeatureDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarFeatureRequest;
use App\Http\Requests\Admin\UpdateCarFeatureRequest;
use App\Repositories\Admin\CarFeatureRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class CarFeatureController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarFeatureRepository */
    private $carFeatureRepository;

    public function __construct(CarFeatureRepository $carFeatureRepo)
    {
        $this->carFeatureRepository = $carFeatureRepo;
        $this->ModelName = 'carFeatures';
        $this->BreadCrumbName = 'CarFeature';
    }

    /**
     * Display a listing of the CarFeature.
     *
     * @param CarFeatureDataTable $carFeatureDataTable
     * @return Response
     */
    public function index(CarFeatureDataTable $carFeatureDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $carFeatureDataTable->render('admin.car_features.index');
    }

    /**
     * Show the form for creating a new CarFeature.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.car_features.create');
    }

    /**
     * Store a newly created CarFeature in storage.
     *
     * @param CreateCarFeatureRequest $request
     *
     * @return Response
     */
    public function store(CreateCarFeatureRequest $request)
    {
        $input = $request->all();

        $carFeature = $this->carFeatureRepository->create($input);

        Flash::success('Car Feature saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carFeatures.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.carFeatures.edit', $carFeature->id));
        } else {
            $redirect_to = redirect(route('admin.carFeatures.index'));
        }
        return $redirect_to;
    }

    /**
     * Display the specified CarFeature.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carFeature = $this->carFeatureRepository->findWithoutFail($id);

        if (empty($carFeature)) {
            Flash::error('Car Feature not found');
            return redirect(route('admin.carFeatures.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carFeature);
        return view('admin.car_features.show')->with('carFeature', $carFeature);
    }

    /**
     * Show the form for editing the specified CarFeature.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carFeature = $this->carFeatureRepository->findWithoutFail($id);

        if (empty($carFeature)) {
            Flash::error('Car Feature not found');
            return redirect(route('admin.carFeatures.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carFeature);
        return view('admin.car_features.edit')->with('carFeature', $carFeature);
    }

    /**
     * Update the specified CarFeature in storage.
     *
     * @param  int $id
     * @param UpdateCarFeatureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarFeatureRequest $request)
    {
        $carFeature = $this->carFeatureRepository->findWithoutFail($id);

        if (empty($carFeature)) {
            Flash::error('Car Feature not found');
            return redirect(route('admin.carFeatures.index'));
        }

        $carFeature = $this->carFeatureRepository->update($request->all(), $id);

        Flash::success('Car Feature updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carFeatures.create'));
        } else {
            $redirect_to = redirect(route('admin.carFeatures.index'));
        }
        return $redirect_to;
    }

    /**
     * Remove the specified CarFeature from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carFeature = $this->carFeatureRepository->findWithoutFail($id);

        if (empty($carFeature)) {
            Flash::error('Car Feature not found');
            return redirect(route('admin.carFeatures.index'));
        }

        $this->carFeatureRepository->delete($id);

        Flash::success('Car Feature deleted successfully.');
        return redirect(route('admin.carFeatures.index'));
    }
}
