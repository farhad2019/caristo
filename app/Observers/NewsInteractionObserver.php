<?php

namespace App\Observers;

use App\Models\NewsInteraction;

class NewsInteractionObserver
{
    public function created(NewsInteraction $model)
    {
        $news = $model->news;
        $prop = $this->getProp($model->type);
        if ($prop) {
            $news->$prop += 1;
            $news->save();
        }
    }

    public function deleted(NewsInteraction $model)
    {
        $news = $model->news;
        $prop = $this->getProp($model->type);
        if ($prop) {
            $news->$prop -= 1;
            $news->save();
        }
    }

    private function getProp($type)
    {
        $prop = false;
        switch ($type) {
            case NewsInteraction::TYPE_VIEW: {
                $prop = "views_count";
                break;
            }
            case NewsInteraction::TYPE_LIKE: {
                $prop = "like_count";
                break;
            }
            case NewsInteraction::TYPE_FAVORITE: {
                $prop = "favorite_count";
                break;
            }
        }
        return $prop;
    }

}
