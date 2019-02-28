<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CourseRepository
 * @package App\Repositories\Admin
 * @version February 26, 2019, 10:57 am UTC
 *
 * @method Course findWithoutFail($id, $columns = ['*'])
 * @method Course find($id, $columns = ['*'])
 * @method Course first($columns = ['*'])
*/
class CourseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'category_id',
        'location',
        'language',
        'duration'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Course::class;
    }

    /**
     * @param $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $input['currency'] = 'AED';
        $input['date'] = Carbon::parse($input['date'])->format('Y-m-d');

        $course = $this->create($input);

        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $key => $mediaFile) {
//                $media[] = $this->handlePicture($mediaFile);
                $media[] = [
                    'title'    => $key,
                    'filename' => Storage::putFile('Courses', $mediaFile)
                ]; //$media[$key] = Utils::handlePicture($mediaFile);
            }

            $course->media()->createMany($media);
        }

        return $course;
    }

    public function updateRecord($request, $course)
    {
        $input = $request->all();
        $course = $this->update($input, $course->id);
        return $course;
    }
}
