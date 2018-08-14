<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\NewsInteractionDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateNewsInteractionRequest;
use App\Http\Requests\Admin\UpdateNewsInteractionRequest;
use App\Repositories\Admin\NewsInteractionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class NewsInteractionController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  NewsInteractionRepository */
    private $newsInteractionRepository;

    public function __construct(NewsInteractionRepository $newsInteractionRepo)
    {
        $this->newsInteractionRepository = $newsInteractionRepo;
        $this->ModelName = 'newsInteractions';
        $this->BreadCrumbName = 'NewsInteraction';
    }

    /**
     * Display a listing of the NewsInteraction.
     *
     * @param NewsInteractionDataTable $newsInteractionDataTable
     * @return Response
     */
    public function index(NewsInteractionDataTable $newsInteractionDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $newsInteractionDataTable->render('admin.news_interactions.index');
    }

    /**
     * Show the form for creating a new NewsInteraction.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.news_interactions.create');
    }

    /**
     * Store a newly created NewsInteraction in storage.
     *
     * @param CreateNewsInteractionRequest $request
     *
     * @return Response
     */
    public function store(CreateNewsInteractionRequest $request)
    {
        $input = $request->all();

        $newsInteraction = $this->newsInteractionRepository->create($input);

        Flash::success('News Interaction saved successfully.');

        return redirect(route('admin.newsInteractions.index'));
    }

    /**
     * Display the specified NewsInteraction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $newsInteraction = $this->newsInteractionRepository->findWithoutFail($id);

        if (empty($newsInteraction)) {
            Flash::error('News Interaction not found');

            return redirect(route('admin.newsInteractions.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $newsInteraction);
        return view('admin.news_interactions.show')->with('newsInteraction', $newsInteraction);
    }

    /**
     * Show the form for editing the specified NewsInteraction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $newsInteraction = $this->newsInteractionRepository->findWithoutFail($id);

        if (empty($newsInteraction)) {
            Flash::error('News Interaction not found');

            return redirect(route('admin.newsInteractions.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $newsInteraction);
        return view('admin.news_interactions.edit')->with('newsInteraction', $newsInteraction);
    }

    /**
     * Update the specified NewsInteraction in storage.
     *
     * @param  int              $id
     * @param UpdateNewsInteractionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNewsInteractionRequest $request)
    {
        $newsInteraction = $this->newsInteractionRepository->findWithoutFail($id);

        if (empty($newsInteraction)) {
            Flash::error('News Interaction not found');

            return redirect(route('admin.newsInteractions.index'));
        }

        $newsInteraction = $this->newsInteractionRepository->update($request->all(), $id);

        Flash::success('News Interaction updated successfully.');

        return redirect(route('admin.newsInteractions.index'));
    }

    /**
     * Remove the specified NewsInteraction from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $newsInteraction = $this->newsInteractionRepository->findWithoutFail($id);

        if (empty($newsInteraction)) {
            Flash::error('News Interaction not found');

            return redirect(route('admin.newsInteractions.index'));
        }

        $this->newsInteractionRepository->delete($id);

        Flash::success('News Interaction deleted successfully.');

        return redirect(route('admin.newsInteractions.index'));
    }
}
