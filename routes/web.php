<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', 'AuthController@index')->name('login');
Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('password', 'AuthController@password')->name('password');
Route::post('password_reset', 'AuthController@password_reset')->name('password_reset');
Route::get('getSchoolIDBoardLists/{id}', 'BoardController@getSchoolIDBoardLists')->name('getSchoolIDBoardLists');
Route::get('getSchoolBoardIDListx/{id}', 'BoardController@getSchoolBoardIDList')->name('getSchoolBoardIDList');
Route::post('urunTanitimiKaydet', 'BoardController@urunTanitimiKaydet')->name('urunTanitimiKaydet');

//Route::group(['middleware' => ['auth']], function () { 
    Route::get('/', 'HomeController@index');
    Route::get('/school', 'SchoolController@index')->name('school.list');
    Route::get('/boardRemove', 'BoardController@boardRemove')->name('boardRemove');
    Route::get('/geri_yukle/{id}', 'BoardController@geri_yukle')->name('board.geri_yukle');
    Route::get('/school/edit/{id}', 'SchoolController@edit')->name('school.edit');
    Route::post('/school/update/{id}', 'SchoolController@update')->name('school.update');
    Route::get('/school/delete/{id}', 'SchoolController@delete')->name('school.delete');
    Route::get('/school/create', 'SchoolController@create')->name('school.add');
    Route::get('/masterKey', 'SchoolController@masterKey')->name('masterKey');
    Route::post('/masterKeySave', 'SchoolController@masterKeySave')->name('masterKeySave');
    Route::post('/school/save', 'SchoolController@save')->name('school.save');
    Route::get('/sender/delete/{id}', 'BoardController@senderDelete');
    Route::post('/tahtauygulamasi', 'BoardController@tahtauygulamasi');
    Route::get('/sender/list', 'BoardController@getSendersList')->name('getSendersList');
    Route::get('/uygulamaIndirme', 'HomeController@uygulamaIndirme')->name('uygulamaIndirme');
    Route::get('/urunTanitimi', 'HomeController@urunTanitimi')->name('urunTanitimi');
	
	
    Route::get('/teacher', 'TeacherController@index')->name('teacher');
    Route::get('/teacher/create', 'TeacherController@create')->name('teacher.add');
    Route::get('/teacher/all', 'TeacherController@all')->name('teacher.all');
    Route::post('/teacher/allSave', 'TeacherController@allSave')->name('teacher.allSave');
    Route::post('/teacher/save', 'TeacherController@save')->name('teacher.save');
    Route::get('/teacher/edit/{id}', 'TeacherController@edit')->name('teacher.edit');
    Route::post('/teacher/update/{id}', 'TeacherController@update')->name('teacher.update');
    Route::get('/teacher/delete/{id}', 'TeacherController@delete')->name('teacher.delete');
	
	
    Route::get('/board/edit/{id}', 'BoardController@edit')->name('board.edit');
    Route::post('/board/update/{id}', 'BoardController@update')->name('board.update');
	Route::get('/board/delete/{id}', 'BoardController@delete')->name('board.delete');
	
	Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/create', 'UserController@create')->name('users.add');
    Route::post('/users/save', 'UserController@save')->name('users.save');
    Route::get('/users/edit/{id}', 'UserController@edit')->name('users.edit');
    Route::post('/users/update/{id}', 'UserController@update')->name('users.update');
    Route::get('/users/delete/{id}', 'UserController@delete')->name('users.delete');
	
	Route::get('/group', 'BoardController@getGroup')->name('group');
	Route::get('/group/add', 'BoardController@createGroup')->name('group.add');
	Route::post('/group/save', 'BoardController@saveGroup')->name('group.save');
	
	Route::get('/group/edit/{id}', 'BoardController@editGroup')->name('group.edit');
	Route::post('/group/updateGroup/{id}', 'BoardController@updateGroup')->name('group.update');
	
	Route::get('/group/delete/{id}', 'BoardController@deleteGroup')->name('group.delete');
	Route::get('/group/hours/{id}', 'BoardController@hoursGroup')->name('group.hours');
	Route::post('/group/kaydet_saat', 'BoardController@kaydetSaat')->name('group.saveHours');
	
	
    Route::get('/board', 'BoardController@index')->name('boards');
	
    Route::get('/announ', 'BoardController@announ')->name('announ');
    Route::get('/announ/create', 'BoardController@announCreate')->name('announ.add');
    Route::post('/announ/save', 'BoardController@announSave')->name('announ.save');
    Route::get('/announ/edit/{id}', 'BoardController@announEdit')->name('announ.edit');
    Route::post('/announ/update/{id}', 'BoardController@announUpdate')->name('announ.update');
    Route::get('/announ/delete/{id}', 'BoardController@announDelete')->name('announ.delete');
	
	
    Route::get('/teacherBoards', 'BoardController@getTeacherBoard')->name('teacherBoards');
    Route::get('/userboard/create', 'BoardController@userboardCreate')->name('userboard.add');
    Route::post('/userboard/save', 'BoardController@userboardSave')->name('userboard.save');
    Route::get('/userboard/edit/{id}', 'BoardController@userboardEdit')->name('userboard.edit');
    Route::post('/userboard/update/{id}', 'BoardController@userboardUpdate')->name('userboard.update');
    Route::get('/userboard/delete/{id}', 'BoardController@userboardDelete')->name('userboard.delete');
    
    Route::get('/categories', 'SchoolController@category')->name('categories');
    Route::get('/category/create', 'SchoolController@createCategory')->name('category.add');
    Route::post('/category/save', 'SchoolController@saveCategory')->name('category.save');
    Route::get('/category/edit/{id}', 'SchoolController@categoryEdit')->name('category.edit');
    Route::post('/category/update/{id}', 'SchoolController@categoryUpdate')->name('category.update');
    Route::get('/category/delete/{id}', 'SchoolController@getCategoryDelete')->name('category.delete');
	
	
    Route::get('/uygulamalar', 'BoardController@uygulamalar')->name('uygulamalar');
    Route::get('/uygulamalar/create', 'BoardController@uygulamalarCreate')->name('uygulamalar.add');
    Route::post('/uygulamalar/save', 'BoardController@uygulamalarSave')->name('uygulamalar.save');
    Route::get('/uygulamalar/edit/{id}', 'BoardController@uygulamalarEdit')->name('uygulamalar.edit');
    Route::post('/uygulamalar/update/{id}', 'BoardController@uygulamalarUpdate')->name('uygulamalar.update');
    Route::get('/uygulamalar/delete/{id}', 'BoardController@uygulamalarDelete')->name('uygulamalar.delete');
	
	
    Route::get('/changeLanguage/{lang}', 'HomeController@changeLanguage')->name('changeLanguage');
	
	
    Route::get('/language', 'LanguageController@index')->name('language');
    Route::get('/language/create', 'LanguageController@create')->name('language.create');
    Route::post('/language/store', 'LanguageController@store')->name('language.store');
    Route::get('/language/edit/{code}', 'LanguageController@edit')->name('language.edit');
    Route::post('/language/update/{code}', 'LanguageController@update')->name('language.update');
	Route::get('/language/delete/{code}', 'LanguageController@delete')->name('language.delete');
	Route::get('/language/translation/{code}', 'LanguageController@translation')->name('language.translation');
	Route::post('/language/translation/{code}/save', 'LanguageController@translationSave')->name('language.translation.save');
//});