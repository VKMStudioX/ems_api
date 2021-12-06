<?php

use App\Http\Controllers\KpiController;
use App\Http\Controllers\MyLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RdmUsersController;
use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\EventsController;

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

// public routes
Route::post('/login', [AuthController::class, 'login']);

// Sanctum protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // USER / ADMIN
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // USER - absences
    Route::get('/user_events', [EventsController::class, 'getUserEvents']);
    Route::get('/user_absences', [AbsencesController::class, 'getUserAbsences']);
    Route::post('/manage_user_absences', [AbsencesController::class, 'manageAbsences']);
    
    //ADMIN - users
    Route::get('/admin/get_all_users_events', [EventsController::class, 'getAllUsersEvents']);
    Route::get('/admin/get_all_users', [AuthController::class, 'getAllUsers']);
    Route::post('/admin/register_user', [AuthController::class, 'register']);
    Route::put('/admin/update_user', [AuthController::class, 'updateUser']);
    Route::put('/admin/delete_user', [AuthController::class, 'deleteUser']);
    
    //ADMIN - reminders
    Route::get('/admin/get_all_reminders', [EventsController::class, 'getAllReminders']);
    Route::post('/admin/new_reminder', [EventsController::class, 'newReminder']);
    Route::put('/admin/update_reminder', [EventsController::class, 'updateReminder']);
    Route::put('/admin/delete_reminder', [EventsController::class, 'deleteReminder']);
    
    //ADMIN - holidays
    Route::get('/admin/get_holidays', [AbsencesController::class, 'getHolidays']);
    Route::post('/admin/manage_holidays', [AbsencesController::class, 'manageHolidays']);
    

});

