<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\SubscriberDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateSubscriberRequest;
use App\Http\Requests\Admin\UpdateSubscriberRequest;
use App\Repositories\Admin\SubscriberRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SubscriberController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  SubscriberRepository */
    private $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepo)
    {
        $this->subscriberRepository = $subscriberRepo;
        $this->ModelName = 'subscribers';
        $this->BreadCrumbName = 'Subscriber';
    }

    /**
     * Display a listing of the Subscriber.
     *
     * @param SubscriberDataTable $subscriberDataTable
     * @return Response
     */
    public function index(SubscriberDataTable $subscriberDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $subscriberDataTable->render('admin.subscribers.index');
    }

    /**
     * Show the form for creating a new Subscriber.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.subscribers.create');
    }

    /**
     * Store a newly created Subscriber in storage.
     *
     * @param CreateSubscriberRequest $request
     *
     * @return Response
     */
    public function store(CreateSubscriberRequest $request)
    {
        $input = $request->all();

        $subscriber = $this->subscriberRepository->create($input);

        Flash::success('Subscriber saved successfully.');

        return redirect(route('admin.subscribers.index'));
    }

    /**
     * Display the specified Subscriber.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subscriber = $this->subscriberRepository->findWithoutFail($id);

        if (empty($subscriber)) {
            Flash::error('Subscriber not found');

            return redirect(route('admin.subscribers.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $subscriber);
        return view('admin.subscribers.show')->with('subscriber', $subscriber);
    }

    /**
     * Show the form for editing the specified Subscriber.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subscriber = $this->subscriberRepository->findWithoutFail($id);

        if (empty($subscriber)) {
            Flash::error('Subscriber not found');

            return redirect(route('admin.subscribers.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $subscriber);
        return view('admin.subscribers.edit')->with('subscriber', $subscriber);
    }

    /**
     * Update the specified Subscriber in storage.
     *
     * @param  int              $id
     * @param UpdateSubscriberRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubscriberRequest $request)
    {
        $subscriber = $this->subscriberRepository->findWithoutFail($id);

        if (empty($subscriber)) {
            Flash::error('Subscriber not found');

            return redirect(route('admin.subscribers.index'));
        }

        $subscriber = $this->subscriberRepository->update($request->all(), $id);

        Flash::success('Subscriber updated successfully.');

        return redirect(route('admin.subscribers.index'));
    }

    /**
     * Remove the specified Subscriber from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subscriber = $this->subscriberRepository->findWithoutFail($id);

        if (empty($subscriber)) {
            Flash::error('Subscriber not found');

            return redirect(route('admin.subscribers.index'));
        }

        $this->subscriberRepository->delete($id);

        Flash::success('Subscriber deleted successfully.');

        return redirect(route('admin.subscribers.index'));
    }
}
