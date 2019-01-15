<?php

namespace App\Repositories\Admin;

use App\Models\CarsEvaluation;
use Carbon\Carbon;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarsEvaluationRepository
 * @package App\Repositories\Admin
 * @version January 15, 2019, 7:41 am UTC
 *
 * @method CarsEvaluation findWithoutFail($id, $columns = ['*'])
 * @method CarsEvaluation find($id, $columns = ['*'])
 * @method CarsEvaluation first($columns = ['*'])
 */
class CarsEvaluationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'car_id',
        'user_id',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarsEvaluation::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();

        // current date + 1
        $date = Carbon::now()->addDay();

        // day name in string
        $day = $date->format('l');

        //matches is this day is weekend
        if (in_array($day, CarsEvaluation::WEEK_END)) {

            // add 1 more day
            $expire_at = $date->addDay();

            // day name in string
            $expire_at_day = $expire_at->format('l');

            //matches is this day is weekend
            if (in_array($expire_at_day, CarsEvaluation::WEEK_END)) {

                // add 1 more day
                $expire_at = $date->addDay();
            }
        } else {
            $expire_at = $date;
        }
        $input['expired_at'] = $expire_at;

        $carsEvaluation = $this->create($input);

        return $carsEvaluation;
    }

    /**
     * @param $request
     * @param $carsEvaluation
     * @return mixed
     */
    public function updateRecord($request, $carsEvaluation)
    {
        $input = $request->all();

        $evaluationCar = $this->update($input, $carsEvaluation->id);

        return $evaluationCar;
    }
}
