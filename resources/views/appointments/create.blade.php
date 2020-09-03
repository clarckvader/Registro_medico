@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0 ">Registrar nueva cita</h3>
            </div>
            <div class="col text-right">
                <a href="{{url('patients')}}" class="btn btn-sm btn-danger">
                    Cancelar y volver
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach($errors-> all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif

        <form action="{{url('appointments')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="description">Descripción</label>
            <input name="description" class="form-control" type="text" id="description" rows="3" value="{{old('description')}}" placeholder="Describe brevemente tu consulta" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="specialty">Especialidad</label>
                    <select name="specialty_id" id="specialty" class="form-control" required>
                        <option value="">Seleccionar especialidad</option>
                         @foreach ($specialties as $specialty)
                    <option value="{{$specialty->id}}" @if(old('specialty_id')==$specialty->id) selected @endif>{{$specialty->name}}</option>
                         @endforeach
     
                    </select>

                </div>
                <div class="form-group col-md-6">
                    <label for="doctor">Médicos</label>
                    <select name="doctor_id" id="doctor" class="form-control" required> 
                        @foreach ($doctors as $doctor)
                    <option value="{{$doctor->id}}" @if(old('doctor_id')==$doctor->id) selected @endif>{{$doctor->name}}</option>
                         @endforeach
                    </select>

                </div>
                

            </div>
         

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control datepicker" 
                    placeholder="Seleccionar fecha"
                     id="date" type="text" name="schedule_date" 
                    value="{{old('schedule_date', date('Y-m-d'))}}" 
                    data-date-format="yyyy-mm-dd"
                    data-date-start-date="{{date('Y-m-d')}}" 
                    data-date-end-date="+30d" data-date-language="br">
                </div>
            </div>
            <div class="form-group">
                <label for="hours">Hora de atención</label>
                <div id="hours"> 
                    @if($intervals)
                        @foreach ($intervals['morning'] as $key => $interval)
                        <div class="custom-control custom-radio">
                            <input type="radio" value="{{$interval['start']}}" id="intervalMorning{{ $key }}" name="schedule_time" class="custom-control-input" required>
                            <label class="custom-control-label" for="intervalMorning{{ $key }}">{{$interval['start']}} - {{$interval['end']}}</label>
                        </div>
                         @endforeach
                        
                         @foreach ($intervals['afternoon'] as $key => $interval)
                        <div class="custom-control custom-radio">
                            <input type="radio" value="{{$interval['start']}}" id="intervalAfternoon{{ $key }}" name="schedule_time" class="custom-control-input" required>
                            <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{$interval['start']}} - {{$interval['end']}}</label>
                        </div>
                         @endforeach
                         
                    @else
                    <div class="alert alert alert-primary" role="alert">
                        Selecciona un médico y una fecha para ver los horarios disponibles.
                    </div>
                    @endif
                   
                </div>
            </div>
            <div class="form-group">
                <label for="type">Tipo de consulta</label>
                <div class="custom-control custom-radio">
                    <input type="radio"  id="type1" name="type"  class="custom-control-input"
                    @if(old('type','Consulta')== 'Consulta') checked @endif value="Consulta">
                    <label class="custom-control-label" for="type1">Consulta</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio"  id="type2" name="type" class="custom-control-input"
                    @if(old('type')== 'Examen') checked @endif value="Examen">
                    <label class="custom-control-label" for="type2">Examen</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio"  id="type3" name="type" class="custom-control-input"
                    @if(old('type')== 'Operación') checked @endif value="Operación">
                    <label class="custom-control-label" for="type3">Operación</label>
                </div>
            </div>
            <button type="submit" class="btn btn-success">
                Guardar
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('/js/appointments/create.js')}}"></script>
@endsection