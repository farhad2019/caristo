<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarAttributeDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarAttributeRequest;
use App\Http\Requests\Admin\UpdateCarAttributeRequest;
use App\Models\CarAttribute;
use App\Models\CarAttributeTranslation;
use App\Repositories\Admin\AttributeOptionRepository;
use App\Repositories\Admin\AttributeOptionTranslationRepository;
use App\Repositories\Admin\CarAttributeRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\CarAttributeTranslationRepository;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class CarAttributeController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarAttributeRepository */
    private $carAttributeRepository;

    /** @var  AttributeOptionRepository */
    private $optionRepository;

    /** @var  CarAttributeTranslationRepository */
    private $attributeTranslationRepository;

    /** @var  AttributeOptionTranslationRepository */
    private $optionTranslationRepository;

    public function __construct(CarAttributeRepository $carAttributeRepo, CarAttributeTranslationRepository $attributeTranslationRepo, AttributeOptionRepository $optionRepo, AttributeOptionTranslationRepository $optionTranslationRepo)
    {
        $this->carAttributeRepository = $carAttributeRepo;
        $this->optionRepository = $optionRepo;
        $this->attributeTranslationRepository = $attributeTranslationRepo;
        $this->optionTranslationRepository = $optionTranslationRepo;
        $this->ModelName = 'carAttributes';
        $this->BreadCrumbName = 'CarAttribute';
    }

    /**
     * Display a listing of the CarAttribute.
     *
     * @param CarAttributeDataTable $carAttributeDataTable
     * @return Response
     */
    public function index(CarAttributeDataTable $carAttributeDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $carAttributeDataTable->render('admin.car_attributes.index');
    }

    /**
     * Show the form for creating a new CarAttribute.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.car_attributes.create')->with(['types' => CarAttribute::$ATTRIBUTE_TYPES]);
    }

    /**
     * Store a newly created CarAttribute in storage.
     *
     * @param CreateCarAttributeRequest $request
     *
     * @return Response
     */
    public function store(CreateCarAttributeRequest $request)
    {
        $carAttribute = $this->carAttributeRepository->saveRecord($request);

        if (!empty(array_values(array_filter($request->opt)))) {
            $this->optionRepository->saveRecord($request, $carAttribute);
        }

        Flash::success('Car Attribute saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carAttributes.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.carAttributes.edit', $carAttribute->id));
        } else {
            $redirect_to = redirect(route('admin.carAttributes.index'));
        }
        return $redirect_to;
    }

    /**
     * Display the specified CarAttribute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            Flash::error('Car Attribute not found');
            return redirect(route('admin.carAttributes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carAttribute);
        return view('admin.car_attributes.show')->with('carAttribute', $carAttribute);
    }

    /**
     * Show the form for editing the specified CarAttribute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            Flash::error('Car Attribute not found');
            return redirect(route('admin.carAttributes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $carAttribute);
        return view('admin.car_attributes.edit')->with([
            'types'        => CarAttribute::$ATTRIBUTE_TYPES,
            'carAttribute' => $carAttribute
        ]);
    }

    /**
     * Update the specified CarAttribute in storage.
     *
     * @param  int $id
     * @param UpdateCarAttributeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarAttributeRequest $request)
    {
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            Flash::error('Car Attribute not found');
            return redirect(route('admin.carAttributes.index'));
        }

        $carAttribute = $this->carAttributeRepository->updateRecord($request, $carAttribute);
        if (!empty(array_values(array_filter($request->opt)))) {
            $this->optionRepository->saveRecord($request, $carAttribute);
        }

        Flash::success('Car Attribute updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.carAttributes.create'));
        } else {
            $redirect_to = redirect(route('admin.carAttributes.index'));
        }
        return $redirect_to;
    }

    /**
     * Remove the specified CarAttribute from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            Flash::error('Car Attribute not found');
            return redirect(route('admin.carAttributes.index'));
        }

        $this->carAttributeRepository->delete($id);

        Flash::success('Car Attribute deleted successfully.');
        return redirect(route('admin.carAttributes.index'));
    }
}
