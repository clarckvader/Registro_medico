<?php

namespace App\Http\Controllers\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WorkDay;

class ScheduleController extends Controller
{
    private $days=[
        'lunes','Martes','Miércoles',
        'Jueves','Viernes','Sábado','Domingo'

    ];

    public function edit()
    {
        
        $workDays = WorkDay::where('user_id', auth()->id())->get();
        $workDays->map(function($wkDay){
            $wkDay->morning_start = (new Carbon($wkDay->morning_start))->format('g:i A');
            $wkDay->morning_end = (new Carbon($wkDay->morning_end))->format('g:i A');
            $wkDay->afternoon_start = (new Carbon($wkDay->afternoon_start))->format('g:i A');
            $wkDay->afternoon_end = (new Carbon($wkDay->afternoon_end))->format('g:i A');
            return $wkDay;
        });
        //dd($workDays->toArray());
        $days = $this->days;
        return view('schedule', compact('workDays','days'));
    }

    public function store(Request $request)
    {

      $active = $request->input('active') ?: [];
      $morning_start = $request->input('morning_start');
      $morning_end = $request->input('morning_end');
      $afternoon_start = $request->input('afternoon_start');
      $afternoon_end = $request->input('afternoon_end');
     
        $errors = [];
        for($i=0; $i<7; ++$i){
            if($morning_start[$i]>=$morning_end[$i]){
                $errors[]= 'Las horas del turno mañana son inconsistentes para el dia ' . $this->days[$i] . '.' ;
                
            }
            if($afternoon_start[$i]>=$afternoon_end[$i]){
                $errors[]= 'Las horas del turno tarde son inconsistentes para el dia ' . $this->days[$i] . '.';
            }

            WorkDay::updateOrCreate(
                [
                    'day'=> $i,
                    'user_id'=> auth()->id()
            ],
            [
                'active' => in_array($i, $active),
    
                'morning_start'=>$morning_start[$i],
                'morning_end'=>$morning_end[$i],
            
                'afternoon_start'=>$afternoon_start[$i],
                'afternoon_end'=>$afternoon_end[$i],
            ]
            );
        }
            
        

            if(count($errors)>0)
                return back()->with(compact('errors'));
            $notification='Los cambios se han guardado correctamente';
            return back()->with(compact('notification'));   
            
       
    }
       
        
}
    