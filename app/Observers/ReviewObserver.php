<?php

namespace App\Observers;

use App\Models\MyCar;
use App\Models\Review;

/**
 * Class ReviewObserver
 * @package App\Observers
 */
class ReviewObserver
{
    /**
     * @param Review $model
     */
    public function updated(Review $model)
    {
        $review = Review::where('car_id', $model->car_id)->avg('average_rating');
        MyCar::where('id', $model->car_id)->update(['average_rating' => round($review, 2)]);
    }
}