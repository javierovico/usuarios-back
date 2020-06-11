<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@usuarios.com.py';
        $user->password = Hash::make('adm1n');
        $user->save();
        $user->addRol('user','admin');  //le agrega ambos roles
    }
}
