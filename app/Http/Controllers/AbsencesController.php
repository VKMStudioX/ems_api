<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Holiday;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class AbsencesController extends Controller
{

    /**
     * Get User absences.
     *
     * @param int $id
     * @return array
     */
    public function getUserAbsences(Request $request): object
    {
        $userAbsences = Absence::select('start')
            ->where('user_id', $request->id)
            ->get();

            // foreach($userAbsences as $absence) {
            //     if(!is_null($absence['start'])){
            // $absence['start'] = date('Y-m-d', strtotime($absence['start']));
            //     }
            // };

         return response([
            'user_id' => $request->id,
            'user_absences' => $userAbsences
        ], 200);
    }


     /**
     * create/update/remove user absence(s)
     *
     * @param Request $request
     * @return Response
     */
    public function manageAbsences(Request $request): object
    {

        $absencesFromDb = Absence::get()->toArray();
        $oldAbsencesTime = array_map(function($o) { return Carbon::parse($o['start'])->format('Y-m-d 23:00:00');}, $absencesFromDb);
        $oldAbsencesUserId = array_map(function($o) { return $o['user_id'];}, $absencesFromDb);

        $userId = $request->user_id;
        $newAbsencesFromReq = $request->absences;
        $remAbsencesFromReq = $request->removed_absences;
        $remAbsences = array_map(function($rA) { return date('Y-m-d 23:00:00', strtotime($rA));}, $remAbsencesFromReq);
        $newAbsences = array_map(function($nA) { return date('Y-m-d 23:00:00', strtotime($nA));}, $newAbsencesFromReq);
        

        DB::beginTransaction();
        try {

                if(isset($remAbsences)) {
                    foreach ($remAbsences as $remDate) {
                        if (in_array($remDate, $oldAbsencesTime) && in_array($userId, $oldAbsencesUserId) && !in_array($remDate, $newAbsences)) {
                            Absence::where('user_id', '=', $userId)
                            ->where('start', '=', $remDate)
                            ->delete();
                        }
                    }
                }

                if(isset($newAbsences)) {
                    foreach ($newAbsences as $newDate) {
                        $newData = [
                                'user_id' => $userId,
                                'start' => $newDate
                            ];

                        if (!in_array($newDate, $oldAbsencesTime) || !in_array($userId, $oldAbsencesUserId) ) {
                             Absence::insert($newData);
                        }
                    }
                }
        
            $response = [
                        'message' => 'user absences updated',
                        'oldAbsences' => $absencesFromDb,
                        'newAbsences' => $newAbsences,
                        'remAbsences' => $remAbsences
                    ];

            DB::commit();
        
            return response($response, 200);

        } catch (Exception $e) {
            DB::rollback();

            return response([
                'error' => $e,
                'message' => 'Error occurred, operation terminated.'
            ], 406);
        }
    }
    


    /**
     * Get User absences.
     *
     * @param null
     * @return array
     */
    public function getHolidays(): object
    {
        $holidays = Holiday::select('start')
            ->get()->toArray();

        foreach($holidays as $holiday) {
            if(!is_null($holiday['start'])){
        $holiday['start'] = date('Y-m-d', strtotime($holiday['start']));
            }
        };

         return response([
            'holidays' => $holidays
        ], 200);
    }


     /**
     * create/update/remove user absence(s)
     *
     * @param Request $request
     * @return Response
     */
    public function manageHolidays(Request $request): object
    {
        $holidaysFromDb = Holiday::get()->toArray();
        $oldHolidays = array_map(function($o) { return Carbon::parse($o['start'])->format('Y-m-d 23:00:00');}, $holidaysFromDb);

        $newHolidaysFromReq = $request->holidays;
        $remHolidaysFromReq = $request->removed_holidays;
        $remHolidays = array_map(function($rH) { return date('Y-m-d 23:00:00', strtotime($rH));}, $remHolidaysFromReq);
        $newHolidays = array_map(function($nH) { return date('Y-m-d 23:00:00', strtotime($nH));}, $newHolidaysFromReq);

        DB::beginTransaction();
        try {

        if(isset($remHolidays)) {
            foreach ($remHolidays as $remDate) {
                if (in_array($remDate, $oldHolidays) && !in_array($remDate, $newHolidays)) {
                    Holiday::where('start', '=', $remDate)
                         ->delete();
                }
            }
        }

        if(isset($newHolidays)) {
            foreach ($newHolidays as $newDate) {
                if (!in_array($newDate, $oldHolidays)) {
                    Holiday::insert(['start' => $newDate]);
                }
            }
        }

        
        
            $response = [
                'message' => 'holidays updated',
                'oldHolidays' => $oldHolidays,
                'newHolidays' => $newHolidays,
                'remHolidays' => $remHolidays
            ];

            DB::commit();
        
            return response($response, 200);

        } catch (Exception $e) {
            DB::rollback();

            return response([
                'error' => $e,
                'message' => 'Error occurred, operation terminated.'
            ], 406);
        }
    }


    }

