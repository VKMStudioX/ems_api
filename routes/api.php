<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Resources\UserResource;
use App\Models\User;
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
    
    Route::group(['prefix'=>'/admin','as'=>'/admin'], function(){
        //ADMIN - users
        Route::get('/get_all_users_events', [EventsController::class, 'getAllUsersEvents']);
        // Route::get('/get_all_users', function () {
        //     return UserResource::collection(User::all());
        // });
        Route::get('/get_all_users', [AuthController::class, 'getAllUsers']);
        Route::post('/register_user', [AuthController::class, 'register']);
        Route::put('/update_user', [AuthController::class, 'updateUser']);
        Route::put('/delete_user', [AuthController::class, 'deleteUser']);

        //ADMIN - reminders
        Route::get('/get_all_reminders', [EventsController::class, 'getAllReminders']);
        Route::post('/new_reminder', [EventsController::class, 'newReminder']);
        Route::put('/update_reminder', [EventsController::class, 'updateReminder']);
        Route::put('/delete_reminder', [EventsController::class, 'deleteReminder']);

        //ADMIN - holidays
        Route::get('/get_holidays', [AbsencesController::class, 'getHolidays']);
        Route::post('/manage_holidays', [AbsencesController::class, 'manageHolidays']);

        //ADMIN - projects
        Route::get('/get_all_projects', [ProjectsController::class, 'getAllProjects']);
        Route::get('/get_all_techTemplates', [ProjectsController::class, 'getAllTechTemplates']);

    });
    
});

