    <!-- Navigation -->
    <h6 class="navbar-heading text-muted text-center">
        @if(auth()->user()->role=='admin')
        Gestionar datos
        @else
        Menu
        @endif

    </h6>
    <ul class="navbar-nav">
        @if(auth()->user()->role=='admin')

        <li class="nav-item">
            <a class="nav-link" href="/home">
                <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/specialties">
                <i class="ni ni-ruler-pencil text-blue"></i> Especialidades
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/doctors">
                <i class="ni ni-badge text-orange"></i> Medicos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/patients">
                <i class="ni ni-single-02 text-yellow"></i> Pacientes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./examples/tables.html">
                <i class="ni ni-bullet-list-67 text-red"></i> Tables
            </a>
        </li>
        @elseif(auth()->user()->role=='doctor') {{---doctor---}}
        <li class="nav-item">
            <a class="nav-link" href="/schedule">
                <i class="ni ni-calendar-grid-58 text-danger"></i> Gestionar horario
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/home">
                <i class="ni ni-time-alarm text-primary"></i> Mis citas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/specialties">
                <i class="ni ni-single-02 text-info"></i> Mis pacientes
            </a>
        </li>
        @else {{---patient---}}
        <li class="nav-item">
            <a class="nav-link" href="/home">
                <i class="ni ni-laptop text-primary"></i> Reservar cita
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/specialties">
                <i class="ni ni-ruler-pencil text-blue"></i> Mis citas
            </a>
        </li>

        @endif



        <li class="nav-item">
            <a class="nav-link" href="" onclick="event.preventDefault(); document.getElementById('formlogout').submit();">
                <i class="ni ni-button-power"></i> Cerrar Sesión
            </a>
            <form action="{{route('logout')}}" method="POST" style="display: none;" id="formlogout">
                @csrf
            </form>
        </li>
    </ul>
    
    @if(auth()->user()->role=='admin')
    <!-- Divider -->
    <hr class="my-3">
    <!-- Heading -->
    <h6 class="navbar-heading text-muted">Reportes</h6>
    <!-- Navigation -->
    <ul class="navbar-nav mb-md-3">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="ni ni-collection text-red"></i> Frecuencia de citas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="ni ni-satisfied  text-info"></i> Medicos mas activos
            </a>
        </li>
    </ul>
    @endif