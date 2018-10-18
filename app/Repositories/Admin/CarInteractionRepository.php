<?php

namespace App\Repositories\Admin;

use App\Models\CarInteraction;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarInteractionRepository
 * @package App\Repositories\Admin
 * @version October 18, 2018, 4:52 am UTC
 *
 * @method CarInteraction findWithoutFail($id, $columns = ['*'])
 * @method CarInteraction find($id, $columns = ['*'])
 * @method CarInteraction first($columns = ['*'])
 */
class CarInteractionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'user_id',
        'car_id',
        'type',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarInteraction::class;
    }

    public function createRecord($data)
    {
        $data = [
            'car_id'  => $data['car_id'],
            'user_id' => \Auth::id(),
            'type'    => $data['type'],
        ];
        $record = $this->findWhere($data)->first();
        if ($record) {
            if ($data['type'] == CarInteraction::TYPE_VIEW) {
                return true;
            }
            return $record->delete();
        } else {
            return ($this->create($data) != null);
        }
    }

    public function createOrUpdate($data)
    {
        return $this->updateOrCreate([
            'car_id'  => $data['car_id'],
            'user_id' => \Auth::id(),
            'type'    => $data['type'],
        ], [
            'deleted_at' => DB::raw('NOW()')
        ]);
    }
}
