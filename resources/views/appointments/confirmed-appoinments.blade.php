<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Descripción</th>
                <th scope="col">Especialidad</th>
                <th scope="col">Médico</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Tipo</th>
                <th scope="col">Acciones</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($confirmedAppointments as $appointment)
            <tr>
                <th scope="row">
                    {{$appointment->description}}
                </th>
                <td>
                    {{$appointment->specialty->name}}
                </td>
                <td>
                    {{$appointment->doctor->name}}
                </td>
                <td>
                    {{$appointment->schedule_date}}
                </td>
                <td>
                    {{$appointment->schedule_time_12}}
                </td>
                <td>
                    {{$appointment->type}}
                </td>
                
                <td>
                    
                   <a class="btn btn-sm btn-danger" title="cancelar cita" href="{{url('/appointments/'.$appointment->id.'/cancel')}}">Cancelar cita</a>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    {{$confirmedAppointments->links()}}
    
</div>