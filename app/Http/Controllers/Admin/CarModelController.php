<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarModelDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarModelRequest;
use App\Http\Requests\Admin\UpdateCarModelRequest;
use App\Models\CarModel;
use App\Repositories\Admin\CarBrandRepository;
use App\Repositories\Admin\CarModelRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\CarModelTranslationRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class CarModelController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarModelRepository */
    private $carModelRepository;

    /** @var  CarModelTranslationRepository */
    private $carModelTranslationRepository;

    /** @var  CarBrandRepository */
    private $brandRepository;

    /** @var  CarModelRepository */
    private $languageRepository;

    public function __construct(CarModelRepository $carModelRepo, CarModelTranslationRepository $carModelTranslationRepo, CarBrandRepository $brandRepos, LanguageRepository $languageRepo)
    {
        $this->carModelRepository = $carModelRepo;
        $this->carModelTranslationRepository = $carModelTranslationRepo;
        $this->brandRepository = $brandRepos;
        $this->languageRepository = $languageRepo;
        $this->ModelName = 'carModels';
        $this->BreadCrumbName = 'CarModel';
    }

    /**
     * Display a listing of the CarModel.
     *
     * @param CarModelDataTable $carModelDataTable
     * @return Response
     */
    public function index(CarModelDataTable $carModelDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $carModelDataTable->render('admin.car_models.index');
    }

    /**
     * Show the form for creating a new CarModel.
     *
     * @return Response
     */
    public function create()
    {
        $brands = $this->brandRepository->all()->pluck('name', 'id');
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.car_models.create')->with(
            [
                'brands' => $brands
            ]);
    }

    /**
     * Store a newly created CarModel in storage.
     *
     * @param CreateCarModelRequest $request
     *
     * @return Response
     */
    public function store(CreateCarModelRequest $request)
    {
        $carModel = $this->carModelRepository->saveRecord($request);

        Flash::success('Car Model saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carModels.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.carModels.edit', $carModel->id));
        } else {
            $redirect_to = redirect(route('admin.carModels.index'));
        }
        return $redirect_to;
    }

    /**
     * Display the specified CarModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carModel = $this->carModelRepository->findWithoutFail($id);

        if (empty($carModel)) {
            Flash::error('Car Model not found');
            return redirect(route('admin.carModels.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carModel);
        return view('admin.car_models.show')->with('carModel', $carModel);
    }

    /**
     * Show the form for editing the specified CarModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carModel = $this->carModelRepository->findWithoutFail($id);
        if (empty($carModel)) {
            Flash::error('Car Model not found');
            return redirect(route('admin.carModels.index'));
        }

        $locales = $this->languageRepository->orderBy('updated_at', 'ASC')->findWhere(['status' => 1]);
        $brands = $this->brandRepository->all()->pluck('name', 'id');

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carModel);
        return view('admin.car_models.edit')->with([
            'carModel' => $carModel,
            'locales'  => $locales,
            'brands'   => $brands
        ]);
    }

    /**
     * Update the specified CarModel in storage.
     *
     * @param  int $id
     * @param UpdateCarModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarModelRequest $request)
    {
        $carModel = $this->carModelRepository->findWithoutFail($id);

        if (empty($carModel)) {
            Flash::error('Car Model not found');
            return redirect(route('admin.carModels.index'));
        }
        $input['brand_id'] = intval($request->brand_id);
        CarModel::where('id',$carModel->id)->update($input);
        $carModelTranslation = $this->carModelTranslationRepository->updateRecord($request, $carModel);

        Flash::success('Car Model updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carModels.create'));
        } else {
            $redirect_to = redirect(route('admin.carModels.index'));
        }
        return $redirect_to;
    }

    /**
     * Remove the specified CarModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carModel = $this->carModelRepository->findWithoutFail($id);

        if (empty($carModel)) {
            Flash::error('Car Model not found');
            return redirect(route('admin.carModels.index'));
        }

        $this->carModelRepository->delete($id);

        Flash::success('Car Model deleted successfully.');
        return redirect(route('admin.carModels.index'));
    }
}