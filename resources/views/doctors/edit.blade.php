@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Editar Medico</h3>
            </div>
            <div class="col text-right">
                <a href="{{url('doctors')}}" class="btn btn-sm btn-default">
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

        <form action="{{url('doctors/'.$doctor->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name"> Nombre del medico</label>
                <input type="text" name="name" class="form-control" required value="{{old('name',$doctor->name)}}">
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="text" name="email" class="form-control" value="{{old('email',$doctor->email)}}">
            </div>
            <div class="form-group">
                <label for="ci">C.I</label>
                <input type="text" name="ci" class="form-control" value="{{old('ci',$doctor->ci)}}">
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{old('address',$doctor->address)}}">
            </div>
            <div class="form-group">
                <label for="phone">Teléfono/móvil</label>
                <input type="text" name="phone" class="form-control" value="{{old('phone',$doctor->phone)}}">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" name="password" class="form-control" value="">
                <p>* Ingrese un valor solo si desea modificar la contraseña</p>
            </div>
            <button type="submit" class="btn btn-success">
                
                Guardar
            </button>
        </form>
    </div>
</div>
@endsection