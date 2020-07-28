@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Nueva Paciente</h3>
            </div>
            <div class="col text-right">
                <a href="{{url('patients')}}" class="btn btn-sm btn-default">
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

        <form action="{{url('patients')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name"> Nombre del paciente</label>
                <input type="text" name="name" class="form-control" required value="{{old('name')}}">
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="text" name="email" class="form-control" value="{{old('email')}}">
            </div>
            <div class="form-group">
                <label for="ci">C.I</label>
                <input type="text" name="ci" class="form-control" value="{{old('ci')}}">
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{old('address')}}">
            </div>
            <div class="form-group">
                <label for="phone">Teléfono/móvil</label>
                <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" name="password" class="form-control" value="{{(str_random(8))}}">
            </div>
            <button type="submit" class="btn btn-success">
                Guardar
            </button>
        </form>
    </div>
</div>
@endsection