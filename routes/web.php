<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use App\Helpers\ConnectionChecker;
use App\Models\User;

use App\Http\Controllers\ProjectsController;

use App\Http\Resources\UserResource;

use App\Http\Resources\UserCollection;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

// TEST ROUTES - not deleted, but not avaiable from live (commented)

// Route::get('/notification', function (){
//     $user = new User();
//     $user->email = 'vkmstudiox@gmail.com';
//     $subject = 'Hello there!';
//     $message = 'login and password';
//     $data = ['vkmstudiox@gmail.com', 'your_mama'];

//     $user->notify(new App\Notifications\NotifyUser($subject, $message, $data));

//     return $mail = (new App\Notifications\NotifyUser($subject, $message, $data))
//             ->toMail($user);

// });


Route::get('/days-test', function (){

            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            $daysNum = ['1','2','3','4','5','6','7'];
            $daysOfWeek = str_replace($days,$daysNum,"Monday,Sunday");
            $time = explode(":", "12:30");

    return response([
        'daysOfWeek' => $daysOfWeek,
        'time'=> $time,
        'cron' => $time[1] ." ". $time[0] ." * * ". $daysOfWeek
    ], 200);

});



// Route::get('/days-users', function (){
//     $today = Carbon::today();
//     $users = DB::table('users')
//                  ->join('absences', 'users.id', '=', 'users.id')
//                  ->join('holidays', 'absences.start', '!=', 'holidays.start')
//                  ->select('users.*',  
//                          'absences.start', 
//                          'holidays.start')
//                  ->where('users.is_admin', '=', '0')
//                  ->where('absences.start', '!=', $today)
//                  ->where('holidays.start', '!=', $today)
//                  ->where('users.id', '!=', 'users.id')
//                  ->get()
//                  ->toArray();
        
//                  $filteredUser = array_filter($users, function($item) {
//                     static $counts = array();
//                     if(isset($counts[$item->id])) {
//                         return false;
//                     }
//                     $counts[$item->id] = true;
//                     return true;
//                 });

//                 if(!empty($filteredUser)){
    
//                     foreach ($filteredUser as $user){
//                         $user->notify(new NotifyUser(
//                             "User notification - " . $reminder['title_of_reminder'],
//                               $reminder['title_of_reminder'],
//                               $reminder['text_of_reminder'],
//                           ));
//                        return print_r($filteredUser);
//                     }
//                 }
// });


// Route::get('/user/{id}', function ($id) {
//     return new UserResource(User::findOrFail($id));
// });

// Route::get('/users', function () {
//     return UserResource::collection(User::all());
// });


Route::get('/get_all_prjTech', [ProjectsController::class, 'getAllProjectTechnologies']);

Route::get('/get_all_techTemplates', [ProjectsController::class, 'getAllTechTemplates']);

Route::get('/get_all_projects', [ProjectsController::class, 'getAllProjects']);
