<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\WalkThroughDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\CreateWalkThroughRequest;
use App\Http\Requests\Admin\UpdateWalkThroughRequest;
use App\Models\Media;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\WalkThroughRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

/**
 * Class WalkThroughController
 * @package App\Http\Controllers\Admin
 */
class WalkThroughController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  WalkThroughRepository */
    private $walkThroughRepository;

    /** @var  LanguageRepository */
    private $languageRepository;

    public function __construct(WalkThroughRepository $walkThroughRepo, LanguageRepository $languageRepo)
    {
        $this->walkThroughRepository = $walkThroughRepo;
        $this->languageRepository = $languageRepo;
        $this->ModelName = 'walkThroughs';
        $this->BreadCrumbName = 'WalkThrough';
    }

    /**
     * Display a listing of the WalkThrough.
     *
     * @param WalkThroughDataTable $walkThroughDataTable
     * @return Response
     */
    public function index(WalkThroughDataTable $walkThroughDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $walkThroughDataTable->render('admin.walk_throughs.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new WalkThrough.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.walk_throughs.create')->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Store a newly created WalkThrough in storage.
     *
     * @param CreateWalkThroughRequest $request
     *
     * @return Response
     */
    public function store(CreateWalkThroughRequest $request)
    {
        $walkThrough = $this->walkThroughRepository->saveRecord($request);

        Flash::success('Walk Through saved successfully.');
        if (isset($input['continue'])) {
            $redirect_to = redirect(route('admin.walkThroughs.create'));
        } elseif (isset($input['translation'])) {
            $redirect_to = redirect(route('admin.walkThroughs.edit', $walkThrough->id));
        } else {
            $redirect_to = redirect(route('admin.walkThroughs.index'));
        }
        return $redirect_to;
    }

    /**
     * Display the specified WalkThrough.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);
        if (empty($walkThrough)) {
            Flash::error('Walk Through not found');
            return redirect(route('admin.walkThroughs.index'));
        }
        $locales = $this->languageRepository->orderBy('updated_at', 'asc')->findWhere(['status' => 1]);

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $walkThrough);
        return view('admin.walk_throughs.show')->with([
            'walkThrough' => $walkThrough,
            'locales'     => $locales
        ]);
    }

    /**
     * Show the form for editing the specified WalkThrough.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);
        if (empty($walkThrough)) {
            Flash::error('Walk Through not found');
            return redirect(route('admin.walkThroughs.index'));
        }
        $locales = $this->languageRepository->orderBy('updated_at', 'asc')->findWhere(['status' => 1]);

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $walkThrough);
        return view('admin.walk_throughs.edit')->with([
            'title'       => $this->BreadCrumbName,
            'walkThrough' => $walkThrough,
            'locales'     => $locales
        ]);
    }

    /**
     * Update the specified WalkThrough in storage.
     *
     * @param  int $id
     * @param UpdateWalkThroughRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWalkThroughRequest $request)
    {
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);
        if (empty($walkThrough)) {
            Flash::error('Walk Through not found');
            return redirect(route('admin.walkThroughs.index'));
        }

        $this->walkThroughRepository->updateRecord($request, $walkThrough);

        Flash::success('Walk Through updated successfully.');
        if (isset($input['continue'])) {
            $redirect_to = redirect(route('admin.walkThroughs.create'));
        } else {
            $redirect_to = redirect(route('admin.walkThroughs.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified WalkThrough from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);
        if (empty($walkThrough)) {
            Flash::error('Walk Through not found');
            return redirect(route('admin.walkThroughs.index'));
        }

        $this->walkThroughRepository->deleteRecord($id);

        Flash::success('Walk Through deleted successfully.');
        return redirect(route('admin.walkThroughs.index'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function deleteImage($id)
    {
        $propertyMedia = Media::find($id);

        if (empty($propertyMedia)) {
            return response('Not Found');
        }

        $propertyMedia->delete($id);
        return response('Success');
    }

    public function updatePosition(Request $request)
    {
        $response['msg'] = false;
        $input = $request->all();

        if (!empty($input['rowId']) && !empty($input['rowPosition']) && !empty($input['prevRowId']) && !empty($input['prevRowPosition'])) {
            //TODO: current Row
            $row1_id = $input['rowId']; //18
            $row1_position['sort'] = $input['rowPosition']; //18

            //TODO: Previous Row
            $row2_id = $input['prevRowId']; //19
            $row2_position['sort'] = $input['prevRowPosition']; //19

            //TODO: Swapping
            $row1 = $this->walkThroughRepository->update($row1_position, $row2_id);
            $row2 = $this->walkThroughRepository->update($row2_position, $row1_id);

            if ($row1 && $row2) {
                $response['msg'] = true;
            }
        }
        return $response;
    }
}
