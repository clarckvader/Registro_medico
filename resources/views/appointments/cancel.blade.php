@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                        <h3 class="mb-0">Cancelación de cita</h3>
            </div>
                <div class="col text-right">
                    <a href="{{url('patients/create')}}" class="btn btn-sm btn-success">
                            Nueva paciente
                    </a>
                </div>
        </div>
    </div>
    <div class="card-body">
         <!-- Muestra las notificaciones contenidas en notification que vienen de patientController -->
        @if (session('notification'))
        <div class="alert alert-success" role="alert">
             {{session('notification')}}
        </div> 
        @endif
        <p>Estas a punto de cancelar tu cita con el médico {{$appointment->doctor->name}} (especialidad {{$appointment->specialty->name}})  reservada para el dia {{$appointment->schedule_date}}</p>
        

        <form action="{{ url ('/appointments/'.$appointment->id.'/cancel') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="justification">Por favor cuentanos el motivo de la cancelacíon</label>
            <textarea name="justification" id="justification" cols="3"  class="form-control">

            </textarea>
            </div>

            <button class="btn btn-danger" type="submit">Cancelar cita</button>
        <a href="{{url('/appointments')}}" class="btn btn-default" >Volver al listado de citas</a>
        </form>
        
          
               
    </div>

</div>



@endsection