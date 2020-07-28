<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;

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
        return view('doctors.create');
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

         User::create(
            $request->only('name', 'email', 'ci', 'address', 'phone')
            + [
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );
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
        return view('doctors.edit', compact('doctor'));
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
