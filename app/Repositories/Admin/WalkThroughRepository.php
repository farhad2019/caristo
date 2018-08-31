<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\WalkThrough;
use Illuminate\Support\Facades\App;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class WalkThroughRepository
 * @package App\Repositories\Admin
 * @version August 16, 2018, 9:23 am UTC
 *
 * @method WalkThrough findWithoutFail($id, $columns = ['*'])
 * @method WalkThrough find($id, $columns = ['*'])
 * @method WalkThrough first($columns = ['*'])
 */
class WalkThroughRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WalkThrough::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $max_sort = $this->all()->max('sort');
        $input['sort'] = $max_sort + 1;
        $walkThrough = $this->create($input);

        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }
            $walkThrough->media()->createMany($media);
        }
        return $walkThrough;
    }

    /**
     * @param $request
     * @param $walkThrough
     * @return mixed
     */
    public function updateRecord($request, $walkThrough)
    {
//        $input = $request->all();
//        $walkThrough = $this->update($input, $walkThrough->id);

        $input = $request->all();
        //$languageRepository = App::make(LanguageRepository::class);
        $walkThroughTranslationRepository = App::make(WalkThroughTranslationRepository::class);
        $localeList = [];
        foreach ($walkThrough->translations as $translation) {
            $localeList[$translation->id] = $translation->locale;
        }
        #TODO: Test It
        foreach ($input['title'] as $key => $title) {
            if ($title != '') {
//                $locale = $languageRepository->findWhere(['code' => $key])->first()->code;
                $update_data['walk_through_id'] = $walkThrough->id;
                $update_data['locale'] = $key;
                $update_data['title'] = $title;
                $update_data['content'] = $input['content'][$key] ?? null;
                if (array_search($key, $localeList)) {
                    $translation_id = array_search($key, $localeList);
                    $walkThroughTranslationRepository->update($update_data, $translation_id);
                } else {
                    $walkThroughTranslationRepository->create($update_data);
                }
            }
        }

        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }
            $walkThrough->media()->createMany($media);
        }
        return $walkThrough;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $walkThrough = $this->delete($id);
        return $walkThrough;
    }
}