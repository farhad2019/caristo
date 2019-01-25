<?php

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
Route::post('v1/social-login', 'AuthAPIController@socialLogin')->name('socialLogin');
Route::post('v1/register', 'AuthAPIController@register')->name('register');

Route::get('v1/forget-password', 'AuthAPIController@getForgetPasswordCode')->name('forget-password');
//Route::post('v1/resend-code', 'AuthAPIController@resendCode');
Route::post('v1/verify-reset-code', 'AuthAPIController@verifyCode')->name('verify-code');
Route::post('v1/reset-password', 'AuthAPIController@updatePassword')->name('reset-password');


Route::get('v1/getUserByDeviceType', 'UserAPIController@getUserByDeviceType')->name('getUserByDeviceType');

## Token Required to below APIs

Route::middleware('auth:api')->group(function () {
    Route::post('v1/logout', 'AuthAPIController@logout');
    Route::post('v1/refresh', 'AuthAPIController@refresh');
    Route::post('v1/me', 'AuthAPIController@me');
    Route::post('v1/update-push-notification', 'UserAPIController@updatePushNotification');

    Route::resource('v1/users', 'UserAPIController');

    Route::resource('v1/roles', 'RoleAPIController');

    Route::resource('v1/permissions', 'PermissionAPIController');

    Route::resource('v1/contactus', 'ContactUsAPIController');

    Route::resource('v1/notifications', 'NotificationAPIController');

    Route::resource('v1/categories', 'CategoryAPIController');

    Route::resource('v1/news', 'NewsAPIController');

    Route::resource('v1/comments', 'CommentAPIController');

    Route::resource('v1/newsInteractions', 'NewsInteractionAPIController');

    Route::post('v1/change-password', 'AuthAPIController@changePassword')->name('change-password');

    Route::post('v1/update-profile', 'AuthAPIController@updateUserProfile')->name('update-profile');

    Route::get('v1/favorite-news', 'AuthAPIController@favoriteNewsIndex');

    Route::resource('v1/pages', 'PageAPIController');

    Route::resource('v1/news', 'NewsAPIController');

    Route::resource('v1/comments', 'CommentAPIController');

    Route::resource('v1/media', 'MediaAPIController');

    Route::resource('v1/news_interactions', 'NewsInteractionAPIController');

    Route::resource('v1/carAttributes', 'CarAttributeAPIController');

    Route::resource('v1/carFeatures', 'CarFeatureAPIController');

    Route::resource('v1/carTypes', 'CarTypeAPIController');

    Route::resource('v1/engineTypes', 'EngineTypeAPIController');

    Route::resource('v1/myCars', 'MyCarAPIController');

    Route::post('v1/users-regions', 'UserAPIController@addRegion');

    Route::resource('v1/makeBids', 'MakeBidAPIController');

    Route::resource('v1/carInteractions', 'CarInteractionAPIController');

    Route::resource('v1/reportRequests', 'ReportRequestAPIController');

    Route::resource('v1/tradeInCars', 'TradeInCarAPIController');

    Route::resource('v1/reviewAspects', 'ReviewAspectAPIController');

    Route::resource('v1/reviews', 'ReviewAPIController');
});

Route::resource('v1/carTypes', 'CarTypeAPIController');

Route::resource('v1/walkThroughs', 'WalkThroughAPIController');

Route::resource('v1/pages', 'PageAPIController');

Route::resource('v1/regions', 'RegionAPIController');

Route::resource('v1/carBrands', 'CarBrandAPIController');

Route::resource('v1/carModels', 'CarModelAPIController');

Route::resource('v1/languages', 'LanguageAPIController');

Route::resource('v1/regionalSpecifications', 'RegionalSpecificationAPIController');

Route::resource('v1/bidsHistories', 'BidsHistoryAPIController');

Route::resource('v1/cars', 'CarAPIController');

Route::resource('v1/banksRates', 'BanksRateAPIController');

Route::resource('v1/consultancyRequests', 'ConsultancyRequestAPIController');

Route::resource('v1/personalShopperRequests', 'PersonalShopperRequestAPIController');

Route::resource('v1/settings', 'SettingAPIController');

Route::resource('v1/carsEvaluations', 'CarsEvaluationAPIController');

Route::get('v1/brandUsers', 'UserAPIController@brandUsers')->name('brandUsers');