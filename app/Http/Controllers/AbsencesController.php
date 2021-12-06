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

        $userId = $request->user_id;
        $absences = $request->absences;
        $newAbsences = $request->new_absences;
        $removedAbsences = $request->removed_absences;

        DB::beginTransaction();
        try {

        if(isset($newAbsences)) {
            foreach( $newAbsences as $nA) {
            $newDate = Carbon::parse($nA)->format('Y-m-d H:i:00');
            $newData = [
                'user_id' => $userId,
                'start' => $newDate
            ];

             Absence::where('user_id', '=', $userId)
             ->where('start', '!=', $newDate)
             ->insert($newData);
            }
        }

        if(isset($removedAbsences)) {
            foreach( $removedAbsences as $rA) {
                $remDate = Carbon::parse($rA)->format('Y-m-d H:i:00');

             Absence::where('user_id', '=', $userId)
             ->where('start', '=', $remDate)
             ->delete();
            }
        }
            $response = [
                'message' => 'user absence(s) updated'
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
            ->get();

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

        $holidays = $request->holidays;
        $newHolidays = $request->new_holidays;
        $removeHholidays = $request->removed_holidays;

        DB::beginTransaction();
        try {

        if(isset($newHolidays)) {
            foreach( $newHolidays as $nH) {
            $newDate = Carbon::parse($nH)->format('Y-m-d H:i:00');
            $newData = [
                'start' => $newDate
            ];

             Holiday::insert($newData);
            }
        }

        if(isset($removedHolidays)) {
            foreach( $removedHolidays as $rH) {
                $remDate = Carbon::parse($rH)->format('Y-m-d H:i:00');

             Holiday::where('start', '=', $remDate)
             ->delete();
            }
        }
        
            $response = [
                'message' => 'holidays updated'
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

