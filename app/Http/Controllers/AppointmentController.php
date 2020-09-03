<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Interfaces\ScheduleServiceInterface;
use Illuminate\Http\Request;
use App\Specialty;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Appoinment;
use App\CancelledAppointment;

class AppointmentController extends Controller
{
    public function index(){
        $pendingAppointments = Appointment::where('status','Reservada')
        ->where('patient_id', auth()->id())
        ->paginate(10);
        $confirmedAppointments = Appointment::where('status','Confirmada')
        ->where('patient_id', auth()->id())
        ->paginate(10);
        $oldAppointments = Appointment::whereIn('status',['Atendida','Cancelada'])
        ->where('patient_id', auth()->id())
        ->paginate(10);

        return view('appointments.index', compact('pendingAppointments','confirmedAppointments','oldAppointments'));
    }

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

    public function store(Request $request, ScheduleServiceInterface $scheduleService)
    {
        $rules= [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id'=>'exists:users,id',
            'schedule_time' => 'required'
        ];

        $messages = [
            'schedule_time.required'=>'Por favor rellene todos los campos.'
        ];

        //Al utilizar Validator, debemos pasar el request como un arreglo asociativo

        $validator = Validator::make($request->all(),$rules,$messages);

        $validator->after(function ($validator) use ($request, $scheduleService) {
            $date = $request->input('schedule_date');
            $doctorId = $request->input('doctor_id');
            $schedule_time = $request->input('schedule_time');
        
            if ($date && $doctorId && $schedule_time) {
                $start = new Carbon($schedule_time);
                    
            }else{
                return;
            }
            if(!$scheduleService->isAvailableInterval($date, $doctorId , $start)){
                $validator->errors()
                ->add('available_time', 'La hora seleccionada ya se encuentra seleccionada por otro paciente');
            }

        });

        if($validator->fails()){
           return back()
                ->withErrors($validator)
                ->withInput();
        }
        
        
        
        
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

    public function cancelForm(Appointment $appointment)
    {
        if ($appointment->status == 'Confirmada')
            return view('appointments.cancel', compact('appointment'));
        
            return redirect(('/appointments'));
    }


    public function cancel(Appointment $appointment, Request $request)
    {
        if($request->has('justification')){
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by = auth()->id();
            //$cancellation->appointment_id = ;
            //$cancellation->save();

            $appointment->cancellation()->save($cancellation);
        }
            
        $appointment->status = 'Cancelada';
        $appointment->save();
        $notification="La cita se ha cancelado correctamente";
        return redirect('/appointments')->with(compact('notification'));
    }

}
