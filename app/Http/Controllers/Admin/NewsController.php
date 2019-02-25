<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\NewsDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\CreateNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Models\MetaInformation;
use App\Models\News;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\CommentRepository;
use App\Repositories\Admin\NewsRepository;
use App\Repositories\Admin\NotificationRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class NewsController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  NewsRepository */
    private $newsRepository;

    /** @var  CategoryRepository */
    private $categoryRepository;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    /**
     * NewsController constructor.
     * @param NewsRepository $newsRepo
     * @param CategoryRepository $categoryRepository
     * @param CommentRepository $commentRepo
     * @param NotificationRepository $notificationRepo
     */
    public function __construct(NewsRepository $newsRepo, CategoryRepository $categoryRepository, CommentRepository $commentRepo, NotificationRepository $notificationRepo)
    {
        $this->newsRepository = $newsRepo;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepo;
        $this->notificationRepository = $notificationRepo;
        $this->ModelName = 'news';
        $this->BreadCrumbName = 'News';
    }

    /**
     * Display a listing of the News.
     *
     * @param NewsDataTable $newsDataTable
     * @return Response
     */
    public function index(NewsDataTable $newsDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $newsDataTable->render('admin.news.index');
    }

    /**
     * Show the form for creating a new News.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        $categories = [];
        $cats = $this->categoryRepository->getRootCategories2();
        foreach ($cats as $category) {
            if ($category->childCategory()->count() > 0) {
                $categories[$category->name] = $category->childCategory->pluck('name', 'id');
            } else {
                $categories[$category->name] = [$category->id => $category->name];
            }
        }
        return view('admin.news.create')->with(['categories' => $categories]);
    }

    /**
     * Store a newly created News in storage.
     *
     * @param CreateNewsRequest $request
     *
     * @return Response
     */
    public function store(CreateNewsRequest $request)
    {
        $news = $this->newsRepository->createRecord($request);

        if (strlen($request->meta_title) > 0) {
            MetaInformation::create([
                'instance_type' => News::INSTANCE,
                'instance_id'   => $news->id,
                'title'         => $request->meta_title,
                'tags'          => $request->meta_tag ?? '',
                'description'   => $request->meta_description ?? '',
            ]);
        }
        Flash::success('News saved successfully.');
        return redirect(route('admin.news.index'));
    }

    /**
     * Display the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');
            return redirect(route('admin.news.index'));
        }
        $notification = $this->notificationRepository->findWhere(['ref_id' => $id, 'action_type' => Notification::NOTIFICATION_TYPE_COMMENT])->first();
        if (!empty($notification)) {
            $notification->details()->where('user_id', Auth::id())->update(['status' => NotificationUser::STATUS_READ]);
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $news);
        return view('admin.news.show')->with('news', $news);
    }

    /**
     * Show the form for editing the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');
            return redirect(route('admin.news.index'));
        }

        $categories = [];
        $cats = $this->categoryRepository->getRootCategories2();
        foreach ($cats as $category) {
            if ($category->childCategory()->count() > 0) {
                $categories[$category->name] = $category->childCategory->pluck('name', 'id');
            } else {
                $categories[$category->name] = [$category->id => $category->name];
            }
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $news);
        return view('admin.news.edit')->with([
            'news'       => $news,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified News in storage.
     *
     * @param  int $id
     * @param UpdateNewsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNewsRequest $request)
    {
        $news = $this->newsRepository->findWithoutFail($id);
        if (empty($news)) {
            Flash::error('News not found');
            return redirect(route('admin.news.index'));
        }
        $news = $this->newsRepository->updateRecord($request, $news);

        if (strlen($request->meta_title) > 0) {
            if ($news->meta->count() > 0) {
                $news->meta[0]->update([
                    'title'       => $request->meta_title,
                    'tags'        => $request->meta_tag ?? '',
                    'description' => $request->meta_description ?? '',
                ]);
            } else {
                MetaInformation::create([
                    'instance_type' => News::INSTANCE,
                    'instance_id'   => $news->id,
                    'title'         => $request->meta_title,
                    'tags'          => $request->meta_tag ?? '',
                    'description'   => $request->meta_description ?? '',
                ]);
            }
        }

        Flash::success('News updated successfully.');
        return redirect(route('admin.news.index'));
    }

    /**
     * Remove the specified News from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');
            return redirect(route('admin.news.index'));
        }

        $this->newsRepository->delete($id);

        Flash::success('News deleted successfully.');
        return redirect(route('admin.news.index'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function confirmCancel($id)
    {
        $comment = $this->commentRepository->findWithoutFail($id);
        if (empty($comment)) {
            Flash::error('Comment not found');
            return redirect(route('admin.news.index'));
        }
        $comment->delete();

        Flash::success('Status Updated.');
        return redirect()->back();
    }
}
