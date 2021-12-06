<?php

namespace App\Console;

use App\Helpers\ConnectionChecker;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\ReminderTemplate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $reminders = ReminderTemplate::where('active_reminder', '=', '1')->get()->toArray();

        foreach($reminders as $reminder) {
            
            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            $daysNum = ['1','2','3','4','5','6','7'];
            $daysOfWeek = str_replace($days,$daysNum,$reminder['days_of_week']);
            $time = explode(":", $reminder['hour_of_reminder']);

            $schedule->call(function ($reminder) {
                $today = Carbon::today();
                $users = DB::table('users')
                             ->join('absences', 'users.id', '=', 'users.id')
                             ->join('holidays', 'absences.start', '!=', 'holidays.start')
                             ->select('users.*',  
                                     'absences.start', 
                                     'holidays.start')
                             ->where('users.is_admin', '=', '0')
                             ->where('absences.start', '!=', $today)
                             ->where('holidays.start', '!=', $today)
                             ->where('users.id', '!=', 'users.id')
                             ->get()
                             ->toArray();
                    
                             $filteredUser = array_filter($users, function($item) {
                                static $counts = array();
                                if(isset($counts[$item->id])) {
                                    return false;
                                }
                                $counts[$item->id] = true;
                                return true;
                            });
            
                            if(!empty($filteredUser)){
                
                                foreach ($filteredUser as $user){
                                    $user->notify(new NotifyUser(
                                        "User notification - " . $reminder['title_of_reminder'],
                                          $reminder['title_of_reminder'],
                                          $reminder['text_of_reminder'],
                                      ));
                                }
                            }

            })

             ->cron($time[1] ." ". $time[0] ." * * ". $daysOfWeek) // Run every day(s) of week at the specified time
             ->onFailure(function (){
                 echo 'notification failure';
             });
        }
         
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
