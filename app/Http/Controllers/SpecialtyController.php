<?php

namespace App\Http\Controllers;

use App\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //Para añadir una variable que contenga todos los datos en la tabla
        //Especialidades a la vista index, se hace de la siguiente manera
        $specialties = Specialty::all();
        return view('specialties.index', compact('specialties'));
    }
    public function create()
    {
        return view('specialties.create');
    }

    private function performValidation($reques){
        $rules=[
            'name'=>'required| min:5',
        ];
        $messages = [
            'name.required' => 'Este nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 5 caracteres.'
        ];
        $this->validate($reques, $rules, $messages);

    }

    public function store(Request $request)
    {
        $this->performValidation($request);
      
        $specialty = new Specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save(); //Insercion a la bas de datos
        $notification='La especialidad se ha registrado correctamente';
        return redirect('/specialties')->with(compact('notification'));
    }
    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        $this->performValidation($request);
        
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save(); //Actualizacion a la bas de datos
        $notification='La especialidad se ha actualizado correctamente';
        return redirect('/specialties')->with(compact('notification'));
    }

    public function destroy(Specialty $specialty){
        $specialty->delete();
        $notification='La especialidad '.$specialty->name.' se ha eliminado correctamente';
        return redirect('/specialties')->with(compact('notification'));
    }
}
