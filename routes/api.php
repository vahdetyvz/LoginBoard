<?php

//Girissiz
//Board
	Route::post('/board/create', 'Api\BoardController@create');
Route::post('password_reset_send_email', 'Api\UserController@getPasswordResetSendEmail');
Route::post('password_reset', 'Api\UserController@getResetPassword');
Route::post('email_verified', 'Api\UserController@getEmailVerified');
Route::post('phone_verified', 'Api\UserController@getPhoneVerified');
Route::get('/getSchoolList', 'Api\SchoolController@getSchoolList');
Route::post('/getAnnouncements', 'Api\AnnouncementsController@getAnnouncements');
Route::get('/getAnnouncementAll', 'Api\AnnouncementsController@getAnnouncementAll');
Route::get('/getControlBoardHours', 'Api\BoardController@getControlBoardHours');
Route::get('/getMasterKey', 'Api\UserController@getMasterKey');
Route::post('/getDownloadCount', 'Api\AppController@getDownloadCount');
Route::post('/getPopuler', 'Api\AppController@getPopuler');
Route::post('/getControlApp', 'Api\AppController@getControlApp');
Route::post('/debugManager', 'Api\BoardController@debugManager');

//Route::post('/getBoardStatus', 'Api\BoardController@getBoardStatus');
	Route::post('/getChangeBoardStatus', 'Api\BoardController@getChangeBoardStatus');
	Route::post('/getQRDecryptChangeStatus', 'Api\BoardController@getQRDecryptChangeStatus');
	Route::get('/getSchoolBoardList', 'Api\BoardController@getSchoolBoardList');
	Route::get('/getSchoolBoardIDList/{id}', 'Api\BoardController@getSchoolBoardIDList');
	Route::get('/getSchoolIDBoardList/{id}', 'Api\BoardController@getSchoolIDBoardList');
	Route::get('/onlineOfflineCount/{id}', 'Api\BoardController@onlineOfflineCount');
	Route::get('/toplamLisansAdet', 'Api\SchoolController@toplamLisansAdet');
	Route::get('/getSenderList', 'Api\BoardController@getSenderList');
	Route::get('/senderDelete/{id}', 'Api\BoardController@senderDelete');
	Route::post('/tahtaUygulamasi', 'Api\BoardController@tahtaUygulamasi');
	Route::get('/getSchoolDetail', 'Api\SchoolController@getSchoolDetail');

//QR Code
	Route::post('/getQREncrypt', 'Api\QRController@getQREncrypt');
	Route::post('/getQRDecrypt', 'Api\QRController@getQRDecrypt');
	Route::post('/saveHours/{id}', 'Api\BoardController@saveHours');
	Route::get('/getLang', 'Api\LanguageController@getLanguage');
	
	Route::post('/getCategories', 'Api\CategoryController@getCategories');
	Route::post('/getApp', 'Api\AppController@getApp');
	Route::get('/getAppEdit/{id}', 'Api\AppController@getAppEdit');
	Route::get('/getAppEditLang/{id}', 'Api\AppController@getAppEditLang');
	Route::post('/getApps/{id}', 'Api\AppController@getApps');
	Route::post('/getAllApps', 'Api\AppController@getAllApps');
	Route::post('/getSearchApp', 'Api\AppController@getSearchApp');
	Route::get('/getCategory/{id}', 'Api\CategoryController@getCategory');
	Route::post('/category/update/{id}', 'Api\CategoryController@update');
	Route::post('/sender', 'Api\AnnouncementsController@sender');
	Route::get('/getTeacherBoardAllList', 'Api\BoardController@getTeacherBoardAllList');
	Route::get('/getTeachers', 'Api\UserController@getTeachers');
	Route::post('/urunTanitimiSave', 'Api\BoardController@urunTanitimSave');

//Girisli
Route::middleware('jwt.verify')->group(function() {
	Route::get('/test','Api\TestController@getTowns');
	
	Route::get('getUserDelete/{id}', 'Api\AuthController@delete');

	//User
	Route::get('/getUser/{id}', 'Api\UserController@getUser');
	Route::get('/user', 'Api\UserController@index');
	Route::get('/users', 'Api\UserController@getUsers');
	Route::post('/school/edit/{id}', 'Api\SchoolController@update');
	Route::get('/getSchoolDelete/{id}', 'Api\SchoolController@getSchoolDelete');
	Route::get('/getSchool/{id}', 'Api\SchoolController@getSchool');
	Route::get('me', 'Api\UserController@me');
	Route::post('/passwordReset', 'Api\UserController@passwordReset');
	
	//School
	Route::post('/school/create', 'Api\SchoolController@create');
	
	Route::get('/getGroup', 'Api\BoardController@getGroup');
	Route::get('/hoursGroup/{id}', 'Api\BoardController@hoursGroup');
	Route::get('/getGroups/{id}', 'Api\BoardController@getGroups');
	Route::get('/deleteGroup/{id}', 'Api\BoardController@deleteGroup');
	Route::post('/createGroup', 'Api\BoardController@createGrup');
	Route::post('/updateGrup/{id}', 'Api\BoardController@updateGrup');
	
	Route::get('/teacher', 'Api\SchoolController@getSchoolTeacher');
	
	Route::get('/getTeacher', 'Api\SchoolController@getTeacher');
	
	Route::get('/getTeacherBoardList', 'Api\BoardController@getTeacherBoardList');
	
	
	Route::get('/getUserBoard/{id}', 'Api\BoardController@getUserBoard');
	Route::get('/userboardDelete/{id}', 'Api\BoardController@userboardDelete');
	Route::get('/getBoardList', 'Api\BoardController@getBoardList');
	Route::get('/getBoard/{id}', 'Api\BoardController@getBoard');
	Route::post('/boardUpdate/{id}', 'Api\BoardController@boardUpdate');
	Route::get('/getBoardDelete/{id}', 'Api\BoardController@delete');
	Route::get('/geri_yuklex/{id}', 'Api\BoardController@geri_yuklex');
	Route::get('/getBoardDurumList', 'Api\BoardController@getBoardDurumList');
	
	Route::post('/category/create', 'Api\CategoryController@create');
	Route::get('/getCategoryDelete/{id}', 'Api\CategoryController@getCategoryDelete');
	Route::get('/getCategoryLangDelete/{id}', 'Api\CategoryController@getCategoryLangDelete');
	
	Route::post('/users/update/{id}', 'Api\UserController@update');
	Route::post('/users/register','Api\UserController@register');
	Route::post('/users/password','Api\UserController@password');
	Route::post('/userboardSave','Api\BoardController@userboardSave');
	Route::post('/userboardUpdate/{id}','Api\BoardController@userboardUpdate');
	
	
	Route::get('/getAnnouncement/{id}','Api\AnnouncementsController@getAnnouncement');
	Route::post('/announSave','Api\AnnouncementsController@announSave');
	Route::post('/announUpdate/{id}','Api\AnnouncementsController@announUpdate');
	Route::get('/announDelete/{id}','Api\AnnouncementsController@announDelete');
	
	
	Route::post('/uygulamalar','Api\AppController@getAllApps');
	Route::post('/uygulamalar/save','Api\AppController@uygulamalarSave');
	Route::post('/uygulamalar/update/{id}','Api\AppController@uygulamalarUpdate');
	Route::get('/uygulamalar/delete/{id}','Api\AppController@uygulamaDelete');
	Route::post('/masterKeys','Api\SchoolController@masterKeys');
	Route::get('/settingsx','Api\SchoolController@settingsx');
	Route::get('/urunTanitimix','Api\SchoolController@urunTanitimix');
});

Route::group(['middleware' => 'api','prefix' => 'auth'], function () {
	Route::post('login', 'Api\AuthController@login');
	Route::post('update/{id}', 'Api\AuthController@update');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
    Route::post('payload','Api\AuthController@payload');
    Route::post('register','Api\AuthController@register');
});
//--Example_Route: http://127.0.0.1:8000/api/auth/login
