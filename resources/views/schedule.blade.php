@extends('layouts.panel')

@section('content')
<form action="{{url('/schedule')}}" method="POST">
    @csrf
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                            <h3 class="mb-0">Gestionar horario</h3>
                </div>
                    <div class="col text-right">
                        <button type="submit" class="btn btn-sm btn-success">
                                Guardar cambios
                        </button>
                    </div>
            </div>
        </div>
        <div class="card-body">
             <!-- Muestra las notificaciones contenidas en notification que vienen de doctorController -->
            @if (session('notification'))
            <div class="alert alert-success" role="alert">
                 {{session('notification')}}
            </div> 
    
                
            @endif
                   
        </div>
    
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th scope="col">Dia</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Turno mañana</th>
                                <th scope="col">Turno tarde</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workDays as $key => $workDay)
                            <tr>
                            <th> {{$days[$key]}}</th>
                            <td>
                                <label class="custom-toggle">
                                    <input type="checkbox" name="active[]" value="{{$key}}"
                                        @if ($workDay->active) checked @endif>
                                    <span class="custom-toggle-slider rounded-circle"></span>
                                </label>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" name="morning_start[]">
                                            @for($i=6; $i<=12; $i++)
                                                <option value="{{$i}}:00"
                                                    @if($i.':00 AM' == $workDay->morning_start) selected @endif
                                                > {{$i}}:00 AM </option>
                                                <option value="{{$i}}:30" 
                                                @if($i.':30 AM' == $workDay->morning_start) selected @endif> 
                                                {{$i}}:30 AM </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="morning_end[]">
                                            @for($i=1; $i<=12; $i++)
                                                <option value="{{$i}}:00"
                                                 @if($i.':00 AM' == $workDay->morning_end) selected @endif
                                                > {{$i}}:00 AM </option>
                                                <option value="{{$i}}:30"
                                                @if($i.':30 AM' == $workDay->morning_end) selected @endif
                                                > {{$i}}:30 AM </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" name="afternoon_start[]">
                                            @for($i=1; $i<=11; $i++)
                                                <option value="{{$i+12}}:00"
                                                @if($i.':00 PM' == $workDay->afternoon_start) selected @endif
                                                > {{$i}}:00 PM </option>
                                                <option value="{{$i+12}}:30"
                                                @if($i.':30 PM' == $workDay->afternoon_start) selected @endif
                                                > {{$i}}:30 PM </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="afternoon_end[]">
                                            @for($i=6; $i<=11; $i++)
                                                <option value="{{$i+12}}:00"
                                                @if($i.':00 PM' == $workDay->afternoon_end) selected @endif
                                                > {{$i}}:00 PM </option>
                                                <option value="{{$i+12}}:30"
                                                @if($i.':30 PM' == $workDay->afternoon_end) selected @endif
                                                > {{$i}}:30 PM </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </td>
    
                            </tr>
    
                            @endforeach
    
                        </tbody>
                       
                    </table>
                </div>
    </div>
</form>


@endsection