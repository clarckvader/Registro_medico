<?php

namespace App;

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
}
