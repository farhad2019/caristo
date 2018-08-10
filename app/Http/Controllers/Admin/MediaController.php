<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\MediaDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateMediaRequest;
use App\Http\Requests\Admin\UpdateMediaRequest;
use App\Repositories\Admin\MediaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MediaController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  MediaRepository */
    private $mediaRepository;

    public function __construct(MediaRepository $mediaRepo)
    {
        $this->mediaRepository = $mediaRepo;
        $this->ModelName = 'media';
        $this->BreadCrumbName = 'Media';
    }

    /**
     * Display a listing of the Media.
     *
     * @param MediaDataTable $mediaDataTable
     * @return Response
     */
    public function index(MediaDataTable $mediaDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $mediaDataTable->render('admin.media.index');
    }

    /**
     * Show the form for creating a new Media.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.media.create');
    }

    /**
     * Store a newly created Media in storage.
     *
     * @param CreateMediaRequest $request
     *
     * @return Response
     */
    public function store(CreateMediaRequest $request)
    {
        $input = $request->all();

        $media = $this->mediaRepository->create($input);

        Flash::success('Media saved successfully.');

        return redirect(route('admin.media.index'));
    }

    /**
     * Display the specified Media.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('admin.media.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $media);
        return view('admin.media.show')->with('media', $media);
    }

    /**
     * Show the form for editing the specified Media.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('admin.media.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $media);
        return view('admin.media.edit')->with('media', $media);
    }

    /**
     * Update the specified Media in storage.
     *
     * @param  int              $id
     * @param UpdateMediaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMediaRequest $request)
    {
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('admin.media.index'));
        }

        $media = $this->mediaRepository->update($request->all(), $id);

        Flash::success('Media updated successfully.');

        return redirect(route('admin.media.index'));
    }

    /**
     * Remove the specified Media from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('admin.media.index'));
        }

        $this->mediaRepository->delete($id);

        Flash::success('Media deleted successfully.');

        return redirect(route('admin.media.index'));
    }
}
