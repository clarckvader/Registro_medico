    <!-- Navigation -->
    <h6 class="navbar-heading text-muted">Gestionar datos</h6>
    <ul class="navbar-nav">
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
        <li class="nav-item">
            <a class="nav-link" href="" onclick="event.preventDefault(); document.getElementById('formlogout').submit();">
                <i class="ni ni-button-power"></i> Cerrar Sesión
            </a>
            <form action="{{route('logout')}}" method="POST" style="display: none;" id="formlogout">
                @csrf
            </form>
        </li>
    </ul>
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