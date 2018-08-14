<?php

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Images Resize Route
Route::get('/resize/{img}', function ($img) {

    ob_end_clean();
    try {
        $w = request()->get('w');
        $h = request()->get('h');
        if ($h && $w) {
            // Image Handler lib
            return Image::make(asset("storage/app/$img"))->resize($h, $w, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->response('png');
        } else {
            return response(file_get_contents(storage_path("/app/$img")))
                ->header('Content-Type', 'image/png');
        }

    } catch (\Exception $e) {
//        dd($e->getMessage());
        return abort(404, $e->getMessage());
    }
})->name('resize')->where('img', '(.*)');


/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

## No Token Required
Route::post('v1/login', 'AuthAPIController@login')->name('login');
Route::post('v1/register', 'AuthAPIController@register')->name('register');

Route::get('v1/forget-password', 'AuthAPIController@getForgetPasswordCode')->name('forget-password');
//Route::post('v1/resend-code', 'AuthAPIController@resendCode');
Route::post('v1/verify-reset-code', 'AuthAPIController@verifyCode')->name('verify-code');
Route::post('v1/reset-password', 'AuthAPIController@updatePassword')->name('reset-password');

Route::middleware('auth:api')->group(function () {
    ## Token Required to below APIs
    Route::post('v1/logout', 'AuthAPIController@logout');
    Route::post('v1/refresh', 'AuthAPIController@refresh');
    Route::post('v1/me', 'AuthAPIController@me');

    Route::resource('v1/users', 'UserAPIController');

    Route::resource('v1/roles', 'RoleAPIController');
    Route::resource('v1/permissions', 'PermissionAPIController');

    Route::resource('v1/languages', 'LanguageAPIController');


    Route::resource('v1/contactus', 'ContactUsAPIController');

    Route::resource('v1/notifications', 'NotificationAPIController');

    Route::resource('v1/categories', 'CategoryAPIController');

    Route::resource('v1/news', 'NewsAPIController');

    Route::resource('v1/comments', 'CommentAPIController');


});

Route::resource('v1/pages', 'PageAPIController');


Route::resource('admin/news', 'NewsAPIController');

Route::resource('admin/comments', 'CommentAPIController');

Route::resource('admin/media', 'MediaAPIController');

Route::resource('admin/news_interactions', 'NewsInteractionAPIController');