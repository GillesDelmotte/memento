<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index');
Route::get('/getJobs', 'JobController@index');
Route::post('/addJob', 'JobController@store');
Route::get('/getPractitioners', 'PractitionerController@index');
Route::post('/updateProfile', 'ProfileController@update');
Route::get('/getSchedules', 'ScheduleController@index');
Route::post('/getSchedule', 'ScheduleController@show');
Route::post('/createSchedule', 'ScheduleController@store');
Route::post('/deleteSchedule', 'ScheduleController@destroy');
Route::post('/createAppointment', 'AppointmentController@store');
Route::post('/setAppointments', 'AppointmentController@index');
Route::post('/deleteAppointment', 'AppointmentController@destroy');
Route::post('/getMyAppointments', 'AppointmentController@myAppointments');
Route::post('/addReport', 'ReportController@store');
Route::post('/getReports', 'ReportController@index');
Route::post('/deleteReport', 'ReportController@destroy');


Route::get('/authenticated-user', 'AuthenticatedUserController@fetch');

