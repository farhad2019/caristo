<?php

namespace App\Observers;

use App\Models\CarInteraction;
use App\Models\MyCar;

/**
 * Class CarsInteractionObserver
 * @package App\Observers
 */
class CarsInteractionObserver
{
    /**
     * @param CarInteraction $model
     */
    public function created(CarInteraction $model)
    {
        $cars = MyCar::where('id', $model->car_id)->first();
        //        $cars = $model->cars;

        $prop = $this->getProp($model->type);
        if ($prop) {
            $cars->$prop += 1;
            $cars->save();
        }
    }

    /**
     * @param CarInteraction $model
     */
    public function deleted(CarInteraction $model)
    {
        $cars = MyCar::where('id', $model->car_id)->first();
//        $cars = $model->cars;
        $prop = $this->getProp($model->type);
        if ($prop) {
            $cars->$prop -= 1;
            $cars->save();
        }
    }

    /**
     * @param $type
     * @return bool|string
     */
    private function getProp($type)
    {
        $prop = false;
        switch ($type) {
            case CarInteraction::TYPE_VIEW:
                {
                    $prop = "views_count";
                    break;
                }
            case CarInteraction::TYPE_LIKE:
                {
                    $prop = "like_count";
                    break;
                }
            case CarInteraction::TYPE_FAVORITE:
                {
                    $prop = "favorite_count";
                    break;
                }
        }
        return $prop;
    }

}
