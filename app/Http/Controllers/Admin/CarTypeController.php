<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarTypeDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarTypeRequest;
use App\Http\Requests\Admin\UpdateCarTypeRequest;
use App\Repositories\Admin\CarTypeRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\CarTypeTranslationRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class CarTypeController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarTypeRepository */
    private $carTypeRepository;

    /** @var  CarTypeTranslationRepository */
    private $carTypeTranslationRepository;

    /** @var  LanguageRepository */
    private $languageRepository;

    public function __construct(CarTypeRepository $carTypeRepo, CarTypeTranslationRepository $carTypeTranslationRepo, LanguageRepository $languageRepo)
    {
        $this->carTypeRepository = $carTypeRepo;
        $this->carTypeTranslationRepository = $carTypeTranslationRepo;
        $this->languageRepository = $languageRepo;
        $this->ModelName = 'carTypes';
        $this->BreadCrumbName = 'CarType';
    }

    /**
     * Display a listing of the CarType.
     *
     * @param CarTypeDataTable $carTypeDataTable
     * @return Response
     */
    public function index(CarTypeDataTable $carTypeDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $carTypeDataTable->render('admin.car_types.index');
    }

    /**
     * Show the form for creating a new CarType.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.car_types.create');
    }

    /**
     * Store a newly created CarType in storage.
     *
     * @param CreateCarTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateCarTypeRequest $request)
    {
        $carType = $this->carTypeRepository->saveRecord($request);

        Flash::success('Car Type saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carTypes.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.carTypes.edit', $carType->id));
        } else {
            $redirect_to = redirect(route('admin.carTypes.index'));
        }
        return $redirect_to;
    }

    /**
     * Display the specified CarType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carType = $this->carTypeRepository->findWithoutFail($id);
        if (empty($carType)) {
            Flash::error('Car Type not found');
            return redirect(route('admin.carTypes.index'));
        }

        $locales = $this->languageRepository->orderBy('updated_at', 'ASC')->findWhere(['status' => 1]);
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carType);
        return view('admin.car_types.show')->with([
            'carType' => $carType,
            'locales' => $locales
        ]);
    }

    /**
     * Show the form for editing the specified CarType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carType = $this->carTypeRepository->findWithoutFail($id);
        if (empty($carType)) {
            Flash::error('Car Type not found');
            return redirect(route('admin.carTypes.index'));
        }

        $locales = $this->languageRepository->orderBy('updated_at', 'ASC')->findWhere(['status' => 1]);
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carType);
        return view('admin.car_types.edit')->with([
            'carType' => $carType,
            'locales' => $locales
        ]);
    }

    /**
     * Update the specified CarType in storage.
     *
     * @param  int $id
     * @param UpdateCarTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarTypeRequest $request)
    {

        $carType = $this->carTypeRepository->findWithoutFail($id);
        if (empty($carType)) {
            Flash::error('Car Type not found');
            return redirect(route('admin.carTypes.index'));
        }
        $carTypes= $this->carTypeRepository->updateRecord($request, $carType);
        $this->carTypeTranslationRepository->updateRecord($request, $carType);

        Flash::success('Car Type updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carTypes.create'));
        } else {
            $redirect_to = redirect(route('admin.carTypes.index'));
        }
        return $redirect_to;
    }

    /**
     * Remove the specified CarType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carType = $this->carTypeRepository->findWithoutFail($id);

        if (empty($carType)) {
            Flash::error('Car Type not found');
            return redirect(route('admin.carTypes.index'));
        }

        if ($carType->cars->count() > 0) {
            Flash::error('This car type belongs to car. Cannot be deleted');
            return redirect(route('admin.carTypes.index'));
        }

        $this->carTypeRepository->delete($id);

        Flash::success('Car Type deleted successfully.');
        return redirect(route('admin.carTypes.index'));
    }
}
