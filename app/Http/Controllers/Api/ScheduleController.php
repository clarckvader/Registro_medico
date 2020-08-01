<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WorkDay;
use Carbon\Carbon;

class ScheduleController extends Controller
{
   public function hours(Request $request){

    $rules = [
        'date' => 'required|date_format:"Y-m-d',
        'doctor_id'=>'required|exist_user_id'
    ];

    //dd($request->all());
    $date = $request->input('date');
    $dateCarbon = new Carbon($date);
    $i = $dateCarbon->dayOfWeek;
    $day = ($i==0? 6 : $i-1);

    $doctorId = $request->input('doctor_id');

    $workDay = WorkDay::where('active', true)
        ->where('day', $day)
        ->where('user_id', $doctorId)
        ->first([
            'morning_start','morning_end',
            'afternoon_start','afternoon_end'
        ]);

        $morningIntervals = $this->getIntervals($workDay->morning_start,$workDay->morning_end );
        $AftertoonIntervals = $this->getIntervals($workDay->afternoon_start,$workDay->afternoon_end);

        $data = [];
        $data['morning']=$morningIntervals;    
        $data['afternoon']=$AftertoonIntervals;    
        return $data;
   }

    private function getIntervals($start, $end){
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervals = [];
        while($start < $end){
            $interval = [];
            $interval['start'] = $start->format('g:i A');
            $start->addMinutes(30);
            $interval['end'] = $start->format('g:i A');

            $intervals[]=$interval;
        }
        return $intervals;
    }
}
