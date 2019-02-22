<?php

namespace App\Observers;

use App\Models\Comment;

/**
 * Class CommentObserver
 * @package App\Observers
 */
class CommentObserver
{
    /**
     * @param Comment $model
     */
    public function created(Comment $model)
    {
        $news = $model->news;
        $news->comments_count += 1;
        $news->save();
    }

    /**
     * @param Comment $model
     */
    public function deleted(Comment $model)
    {
        if ($model->news) {
            $news = $model->news;
            $news->comments_count -= 1;
            $news->save();
        }
    }
}