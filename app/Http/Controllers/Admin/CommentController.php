<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CommentDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCommentRequest;
use App\Http\Requests\Admin\UpdateCommentRequest;
use App\Models\Comment;
use App\Repositories\Admin\CommentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CommentController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CommentRepository */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepo)
    {
        $this->commentRepository = $commentRepo;
        $this->ModelName = 'comments';
        $this->BreadCrumbName = 'Comment';
    }

    /**
     * Display a listing of the Comment.
     *
     * @param CommentDataTable $commentDataTable
     * @return Response
     */
    public function index(CommentDataTable $commentDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $commentDataTable->render('admin.comments.index');
    }

    /**
     * Show the form for creating a new Comment.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.comments.create');
    }

    /**
     * Store a newly created Comment in storage.
     *
     * @param CreateCommentRequest $request
     *
     * @return Response
     */
    public function store(CreateCommentRequest $request)
    {
        $input = $request->all();

        $comment = $this->commentRepository->create($input);

        Flash::success('Comment saved successfully.');

        return redirect(route('admin.comments.index'));
    }

    /**
     * Display the specified Comment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            Flash::error('Comment not found');

            return redirect(route('admin.comments.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $comment);
        return view('admin.comments.show')->with('comment', $comment);
    }

    /**
     * Show the form for editing the specified Comment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            Flash::error('Comment not found');

            return redirect(route('admin.comments.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $comment);
        return view('admin.comments.edit')->with('comment', $comment);
    }

    /**
     * Update the specified Comment in storage.
     *
     * @param  int              $id
     * @param UpdateCommentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCommentRequest $request)
    {
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            Flash::error('Comment not found');

            return redirect(route('admin.comments.index'));
        }

        $comment = $this->commentRepository->update($request->all(), $id);

        Flash::success('Comment updated successfully.');

        return redirect(route('admin.comments.index'));
    }

    /**
     * Remove the specified Comment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            Flash::error('Comment not found');

            return redirect(route('admin.comments.index'));
        }

        $this->commentRepository->delete($id);

        Flash::success('Comment deleted successfully.');

        return redirect()->back();
//        return redirect(route('admin.comments.index'));
    }

    public function getNotification()
    {
        $data = Comment::where('deleted_at',null)->orderBy('created_at','desc')->get();
        $resultArray = [];
        $i =0;
        foreach ($data as $item){
            $resultArray[$i] = $item;
            $resultArray[$i]['created_at'] = $resultArray[$i]['created_at']->timezone(session('timezone'));
            $i++;
        }
//        dd($resultArray);

        if (empty($data)) {
            Flash::error('Notification not found');
        }

        return $resultArray;
    }

    public function getAlertNotification()
    {
        $count = Comment::where('status', 20)->all()->count();
        return $count;
    }

    public function markRead($id)
    {
        $value['status'] = 10;
        Comment::where('id',$id)->update($value);
    }
}
