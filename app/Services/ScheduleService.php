<?php 
namespace App\Services;

use App\Appointment;
use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;
use App\WorkDay;


class ScheduleService implements ScheduleServiceInterface
{
    public function isAvailableInterval($date, $doctorId, carbon $start){
        $exists = Appointment::where('doctor_id', $doctorId)
                ->where('schedule_date', $date)
                ->where('schedule_time', $start->format('H:i:s'))
                ->exists();
        
        return !$exists;

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

        $morningIntervals = $this->getIntervals($workDay->morning_start,$workDay->morning_end, $date , $doctorId);
        


        $AftertoonIntervals = $this->getIntervals($workDay->afternoon_start,$workDay->afternoon_end, $date , $doctorId );

        $data = [];
        $data['morning']=$morningIntervals;    
        $data['afternoon']=$AftertoonIntervals;
    
        return $data;
    }

    
    public function getDayFromDate($date)
    {
        
        $dateCarbon = new Carbon($date);
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0? 6 : $i-1);
        return $day;
    }

   

    private function getIntervals($start, $end , $date , $doctorId){
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervals = [];
        while($start < $end){
            $interval = [];
            $interval['start'] = $start->format('g:i A');

            $available = $this->isAvailableInterval($date, $doctorId, $start);

            $start->addMinutes(30);
            $interval['end'] = $start->format('g:i A');

            
            if($available){
                $intervals[]=$interval;
            }
            
        }
        return $intervals;
    }

    
}
