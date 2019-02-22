<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Api\CreateCommentAPIRequest;
use App\Http\Requests\Api\UpdateCommentAPIRequest;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\Admin\CommentRepository;
use App\Repositories\Admin\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CommentController
 * @package App\Http\Controllers\Api
 */
class CommentAPIController extends AppBaseController
{
    /** @var  CommentRepository */
    private $commentRepository;

    /** @var  NotificationRepository */
    private $notificationRepository;

    /**
     * CommentAPIController constructor.
     * @param CommentRepository $commentRepo
     * @param NotificationRepository $notificationRepo
     */
    public function __construct(CommentRepository $commentRepo, NotificationRepository $notificationRepo)
    {
        $this->commentRepository = $commentRepo;
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/comments",
     *      summary="Get a listing of the Comments.",
     *      tags={"Comment"},
     *      description="Get all Comments",
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
     *     @SWG\Parameter(
     *          name="news_id",
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
     *                  @SWG\Items(ref="#/definitions/Comment")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $this->commentRepository->pushCriteria(new RequestCriteria($request));
        $this->commentRepository->pushCriteria(new LimitOffsetCriteria($request));

        extract($input);
        if (isset($news_id)) {
            $comments = $this->commentRepository->getNewsComments($news_id);
        } else {
            $comments = $this->commentRepository->all();
        }


        return $this->sendResponse($comments->toArray(), 'Comments retrieved successfully');
    }

    /**
     * @param CreateCommentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/comments",
     *      summary="Store a newly created Comment in storage",
     *      tags={"Comment"},
     *      description="Store Comment",
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
     *          description="Comment that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Comment")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Comment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateCommentAPIRequest $request)
    {
        $comment = $this->commentRepository->createRecord($request);
        $comments = $this->commentRepository->findWithoutFail($comment->id);

        $notification = [
            'sender_id'   => Auth::id(),
            'action_type' => Notification::NOTIFICATION_TYPE_COMMENT,
            'url'         => null,
            'ref_id'      => $comments->news_id,
            'message'     => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_COMMENT]
        ];
        $this->notificationRepository->notification($notification, User::ADMIN);

        return $this->sendResponse($comments->toArray(), 'Comment saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/comments/{id}",
     *      summary="Display the specified Comment",
     *      tags={"Comment"},
     *      description="Get Comment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Comment",
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
     *                  ref="#/definitions/Comment"
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
        /** @var Comment $comment */
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            return $this->sendError('Comment not found');
        }

        return $this->sendResponse($comment->toArray(), 'Comment retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCommentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/comments/{id}",
     *      summary="Update the specified Comment in storage",
     *      tags={"Comment"},
     *      description="Update Comment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Comment",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *    @SWG\Parameter(
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
     *          description="Comment that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Comment")
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
     *                  ref="#/definitions/Comment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateCommentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Comment $comment */
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            return $this->sendError('Comment not found');
        }

        $comment = $this->commentRepository->update($input, $id);

        return $this->sendResponse($comment->toArray(), 'Comment updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/comments/{id}",
     *      summary="Remove the specified Comment from storage",
     *      tags={"Comment"},
     *      description="Delete Comment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Comment",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *       @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
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
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Comment $comment */
        $comment = $this->commentRepository->findWithoutFail($id);
        $user = Auth::id();
        if (empty($comment)) {
            return $this->sendError('Comment not found');
        }
        if ($comment->user_id == $user) {
            $comment->delete();
        } else {
            return $this->sendError('You can not delete this comment');
        }

        return $this->sendResponse($id, 'Comment deleted successfully');
    }
}