<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarsEvaluationDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarsEvaluationRequest;
use App\Http\Requests\Admin\UpdateCarsEvaluationRequest;
use App\Repositories\Admin\CarsEvaluationRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CarsEvaluationController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarsEvaluationRepository */
    private $carsEvaluationRepository;

    public function __construct(CarsEvaluationRepository $carsEvaluationRepo)
    {
        $this->carsEvaluationRepository = $carsEvaluationRepo;
        $this->ModelName = 'carsEvaluations';
        $this->BreadCrumbName = 'CarsEvaluation';
    }

    /**
     * Display a listing of the CarsEvaluation.
     *
     * @param CarsEvaluationDataTable $carsEvaluationDataTable
     * @return Response
     */
    public function index(CarsEvaluationDataTable $carsEvaluationDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $carsEvaluationDataTable->render('admin.cars_evaluations.index');
    }

    /**
     * Show the form for creating a new CarsEvaluation.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.cars_evaluations.create');
    }

    /**
     * Store a newly created CarsEvaluation in storage.
     *
     * @param CreateCarsEvaluationRequest $request
     *
     * @return Response
     */
    public function store(CreateCarsEvaluationRequest $request)
    {
        $input = $request->all();

        $carsEvaluation = $this->carsEvaluationRepository->create($input);

        Flash::success('Cars Evaluation saved successfully.');

        return redirect(route('admin.carsEvaluations.index'));
    }

    /**
     * Display the specified CarsEvaluation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carsEvaluation = $this->carsEvaluationRepository->findWithoutFail($id);

        if (empty($carsEvaluation)) {
            Flash::error('Cars Evaluation not found');

            return redirect(route('admin.carsEvaluations.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $carsEvaluation);
        return view('admin.cars_evaluations.show')->with('carsEvaluation', $carsEvaluation);
    }

    /**
     * Show the form for editing the specified CarsEvaluation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carsEvaluation = $this->carsEvaluationRepository->findWithoutFail($id);

        if (empty($carsEvaluation)) {
            Flash::error('Cars Evaluation not found');

            return redirect(route('admin.carsEvaluations.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $carsEvaluation);
        return view('admin.cars_evaluations.edit')->with('carsEvaluation', $carsEvaluation);
    }

    /**
     * Update the specified CarsEvaluation in storage.
     *
     * @param  int              $id
     * @param UpdateCarsEvaluationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarsEvaluationRequest $request)
    {
        $carsEvaluation = $this->carsEvaluationRepository->findWithoutFail($id);

        if (empty($carsEvaluation)) {
            Flash::error('Cars Evaluation not found');

            return redirect(route('admin.carsEvaluations.index'));
        }

        $carsEvaluation = $this->carsEvaluationRepository->update($request->all(), $id);

        Flash::success('Cars Evaluation updated successfully.');

        return redirect(route('admin.carsEvaluations.index'));
    }

    /**
     * Remove the specified CarsEvaluation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carsEvaluation = $this->carsEvaluationRepository->findWithoutFail($id);

        if (empty($carsEvaluation)) {
            Flash::error('Cars Evaluation not found');

            return redirect(route('admin.carsEvaluations.index'));
        }

        $this->carsEvaluationRepository->delete($id);

        Flash::success('Cars Evaluation deleted successfully.');

        return redirect(route('admin.carsEvaluations.index'));
    }
}
