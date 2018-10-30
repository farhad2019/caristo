<?php


Auth::routes();

Route::get('/home', 'HomeController@index')->name('dashboard');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('about', 'HomeController@index');

Route::resource('roles', 'RoleController');

Route::resource('modules', 'ModuleController');

Route::get('/module/step1/{id?}', 'ModuleController@getStep1')->name('modules.create');
Route::get('/module/step2/{tablename?}', 'ModuleController@getStep2')->name('modules.create');
Route::get('/getJoinFields/{tablename?}', 'ModuleController@getJoinFields');
Route::get('/module/step3/{tablename?}', 'ModuleController@getStep3')->name('modules.create');

Route::post('/step1', 'ModuleController@postStep1');
Route::post('/step2', 'ModuleController@postStep2');
Route::post('/step3', 'ModuleController@postStep3');


Route::resource('users', 'UserController');

Route::resource('permissions', 'PermissionController');

//Route::resource('profile', 'UserController');

Route::get('user/profile', 'UserController@profile')->name('users.profile');
//Route::patch('users/profile-update/{id}', 'UserController@profileUpdate')->name('users.profile-update');

Route::resource('languages', 'LanguageController');

Route::resource('pages', 'PageController');

Route::resource('contactus', 'ContactUsController');

Route::resource('notifications', 'NotificationController');

Route::resource('menus', 'MenuController');


//Menu #TODO update Menu rout need to be fixed
Route::get('statusChange/{id}', 'MenuController@statusChange');

Route::post('updateChannelPosition', 'MenuController@update_channel_position')->name('channels');

Route::resource('categories', 'CategoryController');

Route::resource('news', 'NewsController');

Route::resource('comments', 'CommentController');

Route::resource('media', 'MediaController');

Route::resource('newsInteractions', 'NewsInteractionController');

Route::resource('walkThroughs', 'WalkThroughController');
Route::get('deleteWTimage/{id}', 'WalkThroughController@deleteImage');

#TODO set it up in resource - update
Route::post('updatePosition', 'WalkThroughController@updatePosition');

Route::resource('carBrands', 'CarBrandController');

Route::resource('carModels', 'CarModelController');

Route::resource('carAttributes', 'CarAttributeController');

Route::resource('carFeatures', 'CarFeatureController');

Route::resource('carTypes', 'CarTypeController');

Route::resource('engineTypes', 'EngineTypeController');

Route::resource('myCars', 'MyCarController');

Route::resource('regions', 'RegionController');

Route::resource('regionalSpecifications', 'RegionalSpecificationController');

Route::resource('makeBids', 'MakeBidController');
Route::get('makeBids/{keyword}', 'MakeBidController@index');

Route::resource('carInteractions', 'CarInteractionController');

Route::resource('reportRequests', 'ReportRequestController');

Route::resource('bidsHistories', 'BidsHistoryController');