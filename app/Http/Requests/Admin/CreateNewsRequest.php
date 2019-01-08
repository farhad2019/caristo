<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;
use App\Models\News;
use Illuminate\Http\Request;

class CreateNewsRequest extends BaseFormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        $youtube_id = $this->checkYoutubeURL($request->video_url);
        $rules = News::$rules;

        if (!$youtube_id && $request->media_type == 20) {
            unset($request['video_url']);
            #TODO: Accept only youtube url. apply custom validation (checkYoutubeURL) in app service provider
            $rules['video_url'] = 'required_without:image|url';
        } else {
            $rules['image'] = 'required_without:video_url';
//            $rules['image'] = 'required_without:video_url|image|mimes:jpg,jpeg,png,bmp|max:5000';
        }

        return $rules;
    }

    public function checkYoutubeURL($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu.be/)([^"&?/ ]{11})%i', $url, $match);
        $youtube_id = @$match[1];
        return $youtube_id;
    }
}
