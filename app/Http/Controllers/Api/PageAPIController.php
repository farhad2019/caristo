<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreatePageAPIRequest;
use App\Http\Requests\Api\UpdatePageAPIRequest;
use App\Models\Page;
use App\Repositories\Admin\PageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\App;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PageController
 * @package App\Http\Controllers\Api
 */
class PageAPIController extends AppBaseController
{
    /** @var  PageRepository */
    private $pageRepository;

    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepository = $pageRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/pages",
     *      summary="Get a listing of the Pages.",
     *      tags={"Page"},
     *      description="Get all Pages",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Page")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        App::setLocale($request->get('locale', 'en'));

        $this->pageRepository->pushCriteria(new RequestCriteria($request));
        $this->pageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pages = $this->pageRepository->all();

        return $this->sendResponse($pages->toArray(), 'Pages retrieved successfully');
    }

    public function store(CreatePageAPIRequest $request)
    {
        $input = $request->all();

        $pages = $this->pageRepository->create($input);

        return $this->sendResponse($pages->toArray(), 'Page saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/pages/{id}",
     *      summary="Display the specified Page",
     *      tags={"Page"},
     *      description="Get Page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Page",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Page"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Page $page */
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        return $this->sendResponse($page->toArray(), 'Page retrieved successfully');
    }

    public function update($id, UpdatePageAPIRequest $request)
    {
        $input = $request->all();

        /** @var Page $page */
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        $page = $this->pageRepository->update($input, $id);

        return $this->sendResponse($page->toArray(), 'Page updated successfully');
    }

    public function destroy($id)
    {
        /** @var Page $page */
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        $page->delete();

        return $this->sendResponse($id, 'Page deleted successfully');
    }
}
