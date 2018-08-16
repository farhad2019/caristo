<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    public function created(Comment $model)
    {
        $news = $model->news;
        $news->comments_count += 1;
        $news->save();
    }

    public function deleted(Comment $model)
    {
        $news = $model->news;
        $news->comments_count -= 1;
        $news->save();
    }
}
