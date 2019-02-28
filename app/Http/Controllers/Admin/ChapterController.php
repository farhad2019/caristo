<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ChapterDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateChapterRequest;
use App\Http\Requests\Admin\UpdateChapterRequest;
use App\Repositories\Admin\ChapterRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ChapterController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ChapterRepository */
    private $chapterRepository;

    public function __construct(ChapterRepository $chapterRepo)
    {
        $this->chapterRepository = $chapterRepo;
        $this->ModelName = 'chapters';
        $this->BreadCrumbName = 'Chapter';
    }

    /**
     * Display a listing of the Chapter.
     *
     * @param ChapterDataTable $chapterDataTable
     * @return Response
     */
    public function index(ChapterDataTable $chapterDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $chapterDataTable->render('admin.chapters.index');
    }

    /**
     * Show the form for creating a new Chapter.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.chapters.create');
    }

    /**
     * Store a newly created Chapter in storage.
     *
     * @param CreateChapterRequest $request
     *
     * @return Response
     */
    public function store(CreateChapterRequest $request)
    {
        $input = $request->all();

        $chapter = $this->chapterRepository->create($input);

        Flash::success('Chapter saved successfully.');

        return redirect(route('admin.chapters.index'));
    }

    /**
     * Display the specified Chapter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $chapter = $this->chapterRepository->findWithoutFail($id);

        if (empty($chapter)) {
            Flash::error('Chapter not found');

            return redirect(route('admin.chapters.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $chapter);
        return view('admin.chapters.show')->with('chapter', $chapter);
    }

    /**
     * Show the form for editing the specified Chapter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $chapter = $this->chapterRepository->findWithoutFail($id);

        if (empty($chapter)) {
            Flash::error('Chapter not found');

            return redirect(route('admin.chapters.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $chapter);
        return view('admin.chapters.edit')->with('chapter', $chapter);
    }

    /**
     * Update the specified Chapter in storage.
     *
     * @param  int              $id
     * @param UpdateChapterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateChapterRequest $request)
    {
        $chapter = $this->chapterRepository->findWithoutFail($id);

        if (empty($chapter)) {
            Flash::error('Chapter not found');

            return redirect(route('admin.chapters.index'));
        }

        $chapter = $this->chapterRepository->update($request->all(), $id);

        Flash::success('Chapter updated successfully.');

        return redirect(route('admin.chapters.index'));
    }

    /**
     * Remove the specified Chapter from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $chapter = $this->chapterRepository->findWithoutFail($id);

        if (empty($chapter)) {
            Flash::error('Chapter not found');

            return redirect(route('admin.chapters.index'));
        }

        $this->chapterRepository->delete($id);

        Flash::success('Chapter deleted successfully.');

        return redirect(route('admin.chapters.index'));
    }
}
