<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\ReminderTemplate;
use Illuminate\Support\Facades\DB;


class EventsController extends Controller
{

   /**
     * Get User absences.
     *
     * @param int $id
     * @return array
     */
    public function getAllUsersEvents(Request $request): object
    {

        $userAbsences = DB::table('users')
                            ->join('absences', 'users.id', '=', 'absences.user_id')
                            ->select('users.first_name', 
                            'users.last_name',
                             'absences.start', 
                             'absences.user_id',
                             'absences.type',
                             )
                            ->get();
 
        $userAbsencesBG = DB::table('absences')
                            ->join('events_defaults_for_bg', 'absences.type', '=', 'events_defaults_for_bg.type')
                            ->select('absences.start',
                             'events_defaults_for_bg.title', 
                             'events_defaults_for_bg.backgroundColor',
                              'events_defaults_for_bg.display',
                               'events_defaults_for_bg.className')
                            ->get();

        $reminders = ReminderTemplate::select('id', 'days_of_week', 'hour_of_reminder', 'title_of_reminder', 'active_reminder', 'text_of_reminder')
            ->get();


         return response([
            'user_reminders' => $reminders,
            'user_absences' => $userAbsences,
            'user_absences_BG' => $userAbsencesBG
        ], 200);

    }

     /**
     * Get User absences.
     *
     * @param int $id
     * @return array
     */
    public function getUserEvents(Request $request): object
    {
        $userAbsences = Absence::select('start')
            ->where('user_id', '=', $request->id)
            ->get();

        $userAbsencesBG = DB::table('absences')
                            ->where('user_id', '=', $request->id)
                            ->join('events_defaults_for_bg', 'absences.type', '=', 'events_defaults_for_bg.type')
                            ->select('absences.start', 'events_defaults_for_bg.title', 'events_defaults_for_bg.backgroundColor', 'events_defaults_for_bg.display', 'events_defaults_for_bg.className')
                            ->get();

        $reminders = ReminderTemplate::select('id', 'days_of_week', 'hour_of_reminder', 'title_of_reminder', 'active_reminder', 'text_of_reminder')
            ->get();

         return response([
            'user_reminders' => $reminders,
            'user_absences' => $userAbsences,
            'user_absences_BG' => $userAbsencesBG,
        ], 200);

    }

    /**
     * Get User absences.
     *
     * @param int $id
     * @return array
     */
    public function getAllReminders(Request $request): object
    {
        $reminders = ReminderTemplate::select('id', 'days_of_week', 'hour_of_reminder', 'title_of_reminder', 'active_reminder', 'text_of_reminder')
            ->get();

         return response([
            'reminders' => $reminders
        ], 200);

    }

    /**
     * Make new Reminder
     *
     * @param Request $request
     * @return array
     */
    public function makeNewReminder(Request $request): object
    {
        $reminders = ReminderTemplate::select('id', 'days_of_week', 'hour_of_reminder', 'title_of_reminder', 'active_reminder', 'text_of_reminder')
            ->get();

         return response([
            'reminders' => $reminders
        ], 200);

    }



     /**
     * Only for EMS admins.
     * Add new EMS reminder.
     *
     * @param Request $request
     * @return Response
     */
    public function newReminder(Request $request): object
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        try {
            $reminder = ReminderTemplate::create([
                'days_of_week' => $request->days_of_week,
                'hour_of_reminder' => $request->hour_of_reminder,
                'active_reminder' => $request->active_reminder,
                'title_of_reminder' => $request->title_of_reminder,
                'text_of_reminder' => $request->text_of_reminder,
            ]);

            $response = [
                'reminder' => $reminder,
                'message' => 'New EMS reminder template created'
            ];

            return response($response, 201);

        } catch (Exception $e) {
           return response([
                'message' => 'Can not create reminder',
                'error' => $e], 401);
        }

    }


      /**
     * Only for EMS admins.
     * Update EMS reminder.
     *
     * @param Request $request
     * @return Response
     */
    public function updateReminder(Request $request)
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        try {
            ReminderTemplate::where('id', $request->id)
                ->when($request->has('days_of_week'), function ($query) use ($request) {
                    $query->update(['days_of_week' => $request->days_of_week]);
                })
               ->when($request->has('hour_of_reminder'), function ($query) use ($request) {
                    $query->update(['hour_of_reminder' => $request->hour_of_reminder]);
                })
                ->when($request->has('title_of_reminder'), function ($query) use ($request) {
                    $query->update(['title_of_reminder' => $request->title_of_reminder]);
                })
                ->when($request->has('text_of_reminder'), function ($query) use ($request) {
                    $query->update(['text_of_reminder' => $request->text_of_reminder]);
                })
                ->when($request->has('active_reminder'), function ($query) use ($request) {
                    $query->update(['active_reminder' => $request->active_reminder]);
                });
                

            $reminder = ReminderTemplate::find($request->id);

            return response([
                'reminder' => $reminder,
                'message' => 'Reminder data updated'
            ], 200);

        } catch (Exception $e) {
            return response([
                'message' => 'Can not update user data'
            ], 401);
        }


    }

    /**
     * Only for EMS admins.
     * Delete EMS user.
     *
     * @param Request $request
     * @return Response
     */
    public function deleteReminder(Request $request): object
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        try {
             ReminderTemplate::destroy($request->id);

            return response([
                'reminder' => $request->id,
                'message' => 'Reminder deleted'
            ], 200);

        } catch (Exception $e) {
           
            return response([
                'message' => 'Can not delete reminder'
            ], 403);
        }
    }
}
