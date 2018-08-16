<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Api\CreateNewsInteractionAPIRequest;
use App\Http\Requests\Api\UpdateNewsInteractionAPIRequest;
use App\Models\NewsInteraction;
use App\Repositories\Admin\NewsInteractionRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NewsInteractionController
 * @package App\Http\Controllers\Api
 */
class NewsInteractionAPIController extends AppBaseController
{
    /** @var  NewsInteractionRepository */
    private $newsInteractionRepository;

    public function __construct(NewsInteractionRepository $newsInteractionRepo)
    {
        $this->newsInteractionRepository = $newsInteractionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/newsInteractions",
     *      summary="Get a listing of the NewsInteractions.",
     *      tags={"NewsInteraction"},
     *      description="Get all NewsInteractions",
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
     *                  @SWG\Items(ref="#/definitions/NewsInteraction")
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
        $this->newsInteractionRepository->pushCriteria(new RequestCriteria($request));
        $this->newsInteractionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $newsInteractions = $this->newsInteractionRepository->all();

        return $this->sendResponse($newsInteractions->toArray(), 'News Interactions retrieved successfully');
    }

    /**
     * @param CreateNewsInteractionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/newsInteractions",
     *      summary="Store a newly created NewsInteraction in storage",
     *      tags={"NewsInteraction"},
     *      description="Store NewsInteraction",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NewsInteraction that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NewsInteraction")
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
     *                  ref="#/definitions/NewsInteraction"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNewsInteractionAPIRequest $request)
    {
        $input = $request->all();

        $newsInteractions = $this->newsInteractionRepository->createRecord($input);

        return $this->sendResponse($newsInteractions, 'News Interaction saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/newsInteractions/{id}",
     *      summary="Display the specified NewsInteraction",
     *      tags={"NewsInteraction"},
     *      description="Get NewsInteraction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NewsInteraction",
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
     *                  ref="#/definitions/NewsInteraction"
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
        /** @var NewsInteraction $newsInteraction */
        $newsInteraction = $this->newsInteractionRepository->findWithoutFail($id);

        if (empty($newsInteraction)) {
            return $this->sendError('News Interaction not found');
        }

        return $this->sendResponse($newsInteraction->toArray(), 'News Interaction retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNewsInteractionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/newsInteractions/{id}",
     *      summary="Update the specified NewsInteraction in storage",
     *      tags={"NewsInteraction"},
     *      description="Update NewsInteraction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NewsInteraction",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NewsInteraction that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NewsInteraction")
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
     *                  ref="#/definitions/NewsInteraction"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNewsInteractionAPIRequest $request)
    {
        $input = $request->all();

        /** @var NewsInteraction $newsInteraction */
        $newsInteraction = $this->newsInteractionRepository->findWithoutFail($id);

        if (empty($newsInteraction)) {
            return $this->sendError('News Interaction not found');
        }

        $newsInteraction = $this->newsInteractionRepository->update($input, $id);

        return $this->sendResponse($newsInteraction->toArray(), 'NewsInteraction updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/newsInteractions/{id}",
     *      summary="Remove the specified NewsInteraction from storage",
     *      tags={"NewsInteraction"},
     *      description="Delete NewsInteraction",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NewsInteraction",
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
        /** @var NewsInteraction $newsInteraction */
        $newsInteraction = $this->newsInteractionRepository->findWithoutFail($id);

        if (empty($newsInteraction)) {
            return $this->sendError('News Interaction not found');
        }

        $newsInteraction->delete();

        return $this->sendResponse($id, 'News Interaction deleted successfully');
    }
}
