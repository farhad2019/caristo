<?php

namespace App\Http\Controllers\Api;

use App\Criteria\ChapterCriteria;
use App\Http\Requests\Api\CreateChapterAPIRequest;
use App\Http\Requests\Api\UpdateChapterAPIRequest;
use App\Models\Chapter;
use App\Repositories\Admin\ChapterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ChapterController
 * @package App\Http\Controllers\Api
 */

class ChapterAPIController extends AppBaseController
{
    /** @var  ChapterRepository */
    private $chapterRepository;

    public function __construct(ChapterRepository $chapterRepo)
    {
        $this->chapterRepository = $chapterRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/chapters",
     *      summary="Get a listing of the Chapters.",
     *      tags={"Chapter"},
     *      description="Get all Chapters",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="course_id",
     *          description="Course Id",
     *          type="integer",
     *          required=true,
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
     *                  @SWG\Items(ref="#/definitions/Chapter")
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
        $this->chapterRepository->pushCriteria(new RequestCriteria($request));
        $this->chapterRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->chapterRepository->pushCriteria(new ChapterCriteria($request));
        $chapters = $this->chapterRepository->all();

        return $this->sendResponse($chapters->toArray(), 'Chapters retrieved successfully');
    }

    /**
     * @param CreateChapterAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/chapters",
     *      summary="Store a newly created Chapter in storage",
     *      tags={"Chapter"},
     *      description="Store Chapter",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Chapter that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/Chapter")
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Chapter"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateChapterAPIRequest $request)
    {
        $input = $request->all();

        $chapters = $this->chapterRepository->create($input);

        return $this->sendResponse($chapters->toArray(), 'Chapter saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/chapters/{id}",
     *      summary="Display the specified Chapter",
     *      tags={"Chapter"},
     *      description="Get Chapter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Chapter",
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
     *                  ref="#/definitions/Chapter"
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
        /** @var Chapter $chapter */
        $chapter = $this->chapterRepository->findWithoutFail($id);

        if (empty($chapter)) {
            return $this->sendError('Chapter not found');
        }

        return $this->sendResponse($chapter->toArray(), 'Chapter retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateChapterAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/chapters/{id}",
     *      summary="Update the specified Chapter in storage",
     *      tags={"Chapter"},
     *      description="Update Chapter",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Chapter",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Chapter that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/Chapter")
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Chapter"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateChapterAPIRequest $request)
    {
        $input = $request->all();

        /** @var Chapter $chapter */
        $chapter = $this->chapterRepository->findWithoutFail($id);

        if (empty($chapter)) {
            return $this->sendError('Chapter not found');
        }

        $chapter = $this->chapterRepository->update($input, $id);

        return $this->sendResponse($chapter->toArray(), 'Chapter updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/chapters/{id}",
     *      summary="Remove the specified Chapter from storage",
     *      tags={"Chapter"},
     *      description="Delete Chapter",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Chapter",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Chapter $chapter */
        $chapter = $this->chapterRepository->findWithoutFail($id);

        if (empty($chapter)) {
            return $this->sendError('Chapter not found');
        }

        $chapter->delete();

        return $this->sendResponse($id, 'Chapter deleted successfully');
    }
}
