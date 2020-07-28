<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        'name' =>'Roberto Flores',
        'email' => 'Roberto@gmail.com',
        'password' => bcrypt('123456'), // password
        
        'ci' => '12345678',
        'address' => 'calle fals 123',
        'phone' => '+5552594',
        'role' => 'admin',

        ]);
        factory(User::class, 50)->create();
    }
}
