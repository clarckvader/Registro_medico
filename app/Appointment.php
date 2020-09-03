<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable=[
        'description',
        'doctor_id',
        'specialty_id',
        'patient_id',
        'schedule_date',
        'schedule_time',
        'type'

    ];

    //relacion N $appointment->specialty 1
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    //appointment->doctor
    public function doctor(){

        return $this->belongsTo(User::class);

    }
    //$appointment->patien
    public function patient()
    {
        return $this->belongsTo(User::class);
    }

    public function cancellation()
    {
        return $this->hasOne(CancelledAppointment::class);
    }



    public function getScheduleTime12Attribute(){
        return (new Carbon($this->schedule_time))->format('g:i A');
    }
}
