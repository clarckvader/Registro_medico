@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                        <h3 class="mb-0">Mis citas</h3>
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

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#Confirmed_Appointments" role="tab" aria-controls="pills-home" aria-selected="true">
                  Mis próximas citas
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#Pending_Appointments" role="tab" aria-controls="pills-profile" aria-selected="false">
                  Citas por confirmar
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#old_Appointments" role="tab" aria-controls="pills-profile" aria-selected="false">
                  Historial de citas atendidas
              </a>
            </li>
            
        </ul>
          
               
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="Confirmed_Appointments" role="tabpanel" >
            @include('appointments.confirmed-appoinments')
        </div>
        <div class="tab-pane fade" id="Pending_Appointments" role="tabpanel" >
            @include('appointments.pending-appoinments')
        </div>
        <div class="tab-pane fade" id="old_Appointments" role="tabpanel" >
            @include('appointments.old-appointments')
        </div>
    </div>
            
    
</div>



@endsection