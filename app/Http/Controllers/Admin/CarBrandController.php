<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarBrandDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarBrandRequest;
use App\Http\Requests\Admin\UpdateCarBrandRequest;
use App\Repositories\Admin\CarBrandRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\CarBrandTranslationRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class CarBrandController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarBrandRepository */
    private $carBrandRepository;

    /** @var  LanguageRepository */
    private $languageRepository;

    /** @var  CarBrandTranslationRepository */
    private $brandTranslationRepository;

    public function __construct(CarBrandRepository $carBrandRepo, CarBrandTranslationRepository $brandTranslationRepo, LanguageRepository $languageRepo)
    {
        $this->carBrandRepository = $carBrandRepo;
        $this->brandTranslationRepository = $brandTranslationRepo;
        $this->languageRepository = $languageRepo;
        $this->ModelName = 'carBrands';
        $this->BreadCrumbName = 'CarBrand';
    }

    /**
     * Display a listing of the CarBrand.
     *
     * @param CarBrandDataTable $carBrandDataTable
     * @return Response
     */
    public function index(CarBrandDataTable $carBrandDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $carBrandDataTable->render('admin.car_brands.index');
    }

    /**
     * Show the form for creating a new CarBrand.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.car_brands.create');
    }

    /**
     * Store a newly created CarBrand in storage.
     *
     * @param CreateCarBrandRequest $request
     *
     * @return Response
     */
    public function store(CreateCarBrandRequest $request)
    {
        $carBrand = $this->carBrandRepository->saveRecord($request);

        Flash::success('Car Brand saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carBrands.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.carBrands.edit', $carBrand->id));
        } else {
            $redirect_to = redirect(route('admin.carBrands.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Display the specified CarBrand.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carBrand = $this->carBrandRepository->findWithoutFail($id);

        if (empty($carBrand)) {
            Flash::error('Car Brand not found');
            return redirect(route('admin.carBrands.index'));
        }
        $locales = $this->languageRepository->orderBy('updated_at', 'ASC')->findWhere(['status' => 1]);
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carBrand);
        return view('admin.car_brands.show')->with(['carBrand' => $carBrand, 'locales' => $locales]);
    }

    /**
     * Show the form for editing the specified CarBrand.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carBrand = $this->carBrandRepository->findWithoutFail($id);

        if (empty($carBrand)) {
            Flash::error('Car Brand not found');

            return redirect(route('admin.carBrands.index'));
        }
        $locales = $this->languageRepository->orderBy('updated_at', 'ASC')->findWhere(['status' => 1]);
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carBrand);
        return view('admin.car_brands.edit')->with(['carBrand' => $carBrand, 'locales' => $locales]);
    }

    /**
     * Update the specified CarBrand in storage.
     *
     * @param  int $id
     * @param UpdateCarBrandRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarBrandRequest $request)
    {
        $carBrand = $this->carBrandRepository->findWithoutFail($id);

        if (empty($carBrand)) {
            Flash::error('Car Brand not found');
            return redirect(route('admin.carBrands.index'));
        }

        $carBrand = $this->carBrandRepository->updateRecord($request, $carBrand);
        $this->brandTranslationRepository->updateRecord($request, $carBrand);

        Flash::success('Car Brand updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carBrands.create'));
        } else {
            $redirect_to = redirect(route('admin.carBrands.index'));
        }
        return $redirect_to;
    }

    /**
     * Remove the specified CarBrand from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carBrand = $this->carBrandRepository->findWithoutFail($id);

        if (empty($carBrand)) {
            Flash::error('Car Brand not found');
            return redirect(route('admin.carBrands.index'));
        }

        if ($carBrand->carModels->count() > 0) {
            Flash::error('This brand has models. Cannot be deleted');
            return redirect(route('admin.carBrands.index'));
        }

        $this->carBrandRepository->delete($id);
        Flash::success('Car Brand deleted successfully.');
        return redirect(route('admin.carBrands.index'));
    }
}