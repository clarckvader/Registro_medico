<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Specialty
Route::get('/specialties', 'SpecialtyController@index');
Route::get('/specialties/create', 'SpecialtyController@create');//Formulario de registro
Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit');


Route::post('/specialties', 'SpecialtyController@store');//Envio de lformulario por metodo post
Route::put('/specialties/{specialty}', 'SpecialtyController@update');

Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy');//Envio de lformulario por metodo post


//Doctors
//otro metodo para no crear cada una de las rutas manualmente con el comando
//php artisan make:controller <Nombre del controlador> --resource
Route::resource('doctors', 'DoctorController');


//patients