<?php 
namespace App\Services;
use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;
use App\WorkDay;


class ScheduleService implements ScheduleServiceInterface
{
    public function getDayFromDate($date)
    {
        
        $dateCarbon = new Carbon($date);
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0? 6 : $i-1);
        return $day;
    }

    public function getAvailableIntervals($date, $doctorId){
        $workDay = WorkDay::where('active', true)
        ->where('day', $this->getDayFromDate($date))
        ->where('user_id', $doctorId)
        ->first([
            'morning_start','morning_end',
            'afternoon_start','afternoon_end'
        ]);

        if(!$workDay){
            return [];
        }

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
