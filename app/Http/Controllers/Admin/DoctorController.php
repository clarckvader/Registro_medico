<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Specialty;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = User::Doctors()->get();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = Specialty::all();
        return view('doctors.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'ci' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];
        $this->validate($request, $rules);

         $user = User::create(
            $request->only('name', 'email', 'ci', 'address', 'phone')
            + [
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );

        //utilizando attach, creamos una nueva relacion entre un medico y sus especialidades
        $user->specialties()->attach($request->input('specialties'));

        $notification = 'El medico se ha registrado correctamente.';
        return redirect('/doctors')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = User::Doctors()->findOrFail($id);
        $specialties = Specialty::all();
        //Usando pluck para obetneer el id de las especialidades asociadas a un medico
        $specialty_ids=$doctor->specialties()->pluck('specialties.id');
        return view('doctors.edit', compact('doctor','specialties', 'specialty_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'ci' => 'nullable|digits:8',
        'address' => 'nullable|min:5',
        'phone' => 'nullable|min:6'
    ];
    $this->validate($request, $rules);

     $user = User::doctors()->findorfail($id);
     $data = $request->only('name', 'email', 'ci', 'address', 'phone');

     //Utilizando Sync, agregamos o eliminamos especilidades sincronizando estas al editar un medico
     $user->specialties()->sync($request->input('specialties')); 
     
     $password = $request->input('password');
    if($password)
        $data['password'] = bcrypt($password);
    
    $user->fill($data);
    $user->save();

    $notification = "La informacion del medico $user->name se ha actualizado correctamente.";
    return redirect('/doctors')->with(compact('notification'));
    }

   
    public function destroy(User $doctor )
    {
        
        $doctor->delete();

        $notification= "El medico $doctor->name se ha eliminado correctamente";
        return redirect('/doctors')->with(compact('notification'));

    }
}
