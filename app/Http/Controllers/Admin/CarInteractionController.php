<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CarInteractionDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCarInteractionRequest;
use App\Http\Requests\Admin\UpdateCarInteractionRequest;
use App\Repositories\Admin\CarInteractionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

class CarInteractionController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CarInteractionRepository */
    private $carInteractionRepository;

    public function __construct(CarInteractionRepository $carInteractionRepo)
    {
        $this->carInteractionRepository = $carInteractionRepo;
        $this->ModelName = 'carInteractions';
        $this->BreadCrumbName = 'CarInteraction';
    }

    /**
     * Display a listing of the CarInteraction.
     *
     * @param CarInteractionDataTable $carInteractionDataTable
     * @return Response
     */
    public function index(CarInteractionDataTable $carInteractionDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $carInteractionDataTable->render('admin.car_interactions.index');
    }

    /**
     * Show the form for creating a new CarInteraction.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.car_interactions.create');
    }

    /**
     * Store a newly created CarInteraction in storage.
     *
     * @param CreateCarInteractionRequest $request
     *
     * @return Response
     */
    public function store(CreateCarInteractionRequest $request)
    {
        $input = $request->all();
        $carInteraction = $this->carInteractionRepository->create($input);

        Flash::success('Car Interaction saved successfully.');
        return redirect(route('admin.carInteractions.index'));
    }

    /**
     * Display the specified CarInteraction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carInteraction = $this->carInteractionRepository->findWithoutFail($id);
        if (empty($carInteraction)) {
            Flash::error('Car Interaction not found');
            return redirect(route('admin.carInteractions.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $carInteraction);
        return view('admin.car_interactions.show')->with('carInteraction', $carInteraction);
    }

    /**
     * Show the form for editing the specified CarInteraction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carInteraction = $this->carInteractionRepository->findWithoutFail($id);

        if (empty($carInteraction)) {
            Flash::error('Car Interaction not found');
            return redirect(route('admin.carInteractions.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $carInteraction);
        return view('admin.car_interactions.edit')->with('carInteraction', $carInteraction);
    }

    /**
     * Update the specified CarInteraction in storage.
     *
     * @param  int              $id
     * @param UpdateCarInteractionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarInteractionRequest $request)
    {
        $carInteraction = $this->carInteractionRepository->findWithoutFail($id);

        if (empty($carInteraction)) {
            Flash::error('Car Interaction not found');
            return redirect(route('admin.carInteractions.index'));
        }

        $carInteraction = $this->carInteractionRepository->update($request->all(), $id);

        Flash::success('Car Interaction updated successfully.');
        return redirect(route('admin.carInteractions.index'));
    }

    /**
     * Remove the specified CarInteraction from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carInteraction = $this->carInteractionRepository->findWithoutFail($id);

        if (empty($carInteraction)) {
            Flash::error('Car Interaction not found');
            return redirect(route('admin.carInteractions.index'));
        }

        $this->carInteractionRepository->delete($id);

        Flash::success('Car Interaction deleted successfully.');
        return redirect(route('admin.carInteractions.index'));
    }
}