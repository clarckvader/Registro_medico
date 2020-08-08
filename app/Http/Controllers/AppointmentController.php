<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Interfaces\ScheduleServiceInterface;
use Illuminate\Http\Request;
use App\Specialty;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function create(ScheduleServiceInterface $scheduleService)
    {
        $specialties = Specialty::all();
        $specailtyId= old('specialty_id');
        if($specailtyId){
            $specialty = Specialty::find($specailtyId);
            $doctors = $specialty->users;
        }else{
            $doctors = collect();
        }

        $scheduleDate = old('schedule_date');
        $doctorId = old('doctor_id');
        if($scheduleDate && $doctorId){
            $intervals = $scheduleService->getAvailableIntervals($scheduleDate, $doctorId);
        }else{
            $intervals = null;
        }



        return view('appointments.create', compact('specialties','doctors', 'intervals'));

    }

    public function store(Request $request)
    {
        $rules= [
            'description' => 'required',
            'specialty_id' =>'exists:specialties,id',
            'doctor_id'=>'exists:doctors,id',
            'schedule_time' => 'required'
        ];

        $messages = [
            'schedule_time.required'=>'Por favor rellene todos los campos.'
        ];

        $this->validate($request, $rules ,$messages);
        $data = $request->only([
        'description',
        'doctor_id',
        'specialty_id',
        
        'schedule_date',
        'schedule_time',
        'type'
        ]);
        $data['patient_id'] = auth()->id();
        $carbonTime =Carbon::createFromFormat('g:i A', $data['schedule_time']);
        $data['schedule_time'] = $carbonTime->format('H:i:s');


        Appointment::create($data);

        $notification = 'La cita se ha guardado correctamnte';
        return back()->with(compact('notification'));
    }

}
