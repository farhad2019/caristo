<?php

namespace App\Http\Controllers\Api;

use App\Criteria\NewsCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Api\CreateNewsAPIRequest;
use App\Http\Requests\Api\UpdateNewsAPIRequest;
use App\Models\News;
use App\Repositories\Admin\NewsRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NewsController
 * @package App\Http\Controllers\Api
 */
class NewsAPIController extends AppBaseController
{
    /** @var  NewsRepository */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepo)
    {
        $this->newsRepository = $newsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/news",
     *      summary="Get a listing of the News.",
     *      tags={"News"},
     *      description="Get all News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="locale",
     *          description="Response Language",
     *          type="string",
     *          default="en",
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="category_id",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
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
     *                  @SWG\Items(ref="#/definitions/News")
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
        \App::setLocale($request->get('locale', 'en'));

        $input = $request->all();

        $this->newsRepository->pushCriteria(new RequestCriteria($request));
        $this->newsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->newsRepository->pushCriteria(new NewsCriteria($request));

        $news = $this->newsRepository->all();
//        $this->newsRepository->resetCriteria();
//        $this->newsRepository->pushCriteria(new RequestCriteria($request));
//        $this->newsRepository->pushCriteria(new LimitOffsetCriteria($request));
//        $this->newsRepository->pushCriteria(new UnreadNewsCriteria($request));

        // FIXME: Find a good way to get count.
//        $count = $this->newsRepository->all()->count();

//        return $this->sendResponse(['unread_count' => $count, 'news' => $news->toArray()], 'News retrieved successfully');
        return $this->sendResponse($news->toArray(), 'News retrieved successfully');
    }

    /**
     * @param CreateNewsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/news",
     *      summary="Store a newly created News in storage",
     *      tags={"News"},
     *      description="Store News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="News that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/News")
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
     *                  ref="#/definitions/News"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNewsAPIRequest $request)
    {
        $input = $request->all();

        $news = $this->newsRepository->create($input);

        return $this->sendResponse($news->toArray(), 'News saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/news/{id}",
     *      summary="Display the specified News",
     *      tags={"News"},
     *      description="Get News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of News",
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
     *                  ref="#/definitions/News"
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
        /** @var News $news */
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        return $this->sendResponse($news->toArray(), 'News retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNewsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/news/{id}",
     *      summary="Update the specified News in storage",
     *      tags={"News"},
     *      description="Update News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of News",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="News that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/News")
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
     *                  ref="#/definitions/News"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNewsAPIRequest $request)
    {
        $input = $request->all();

        /** @var News $news */
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        $news = $this->newsRepository->update($input, $id);

        return $this->sendResponse($news->toArray(), 'News updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/news/{id}",
     *      summary="Remove the specified News from storage",
     *      tags={"News"},
     *      description="Delete News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of News",
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
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var News $news */
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        $news->delete();

        return $this->sendResponse($id, 'News deleted successfully');
    }
}
