<?php

use App\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $role = new Rol();
        $role->name = Rol::NOMBRE_ROL_USER;
        $role->description = 'rol por defecto';
        $role->save();
        $role = new Rol();
        $role->name = Rol::NOMBRE_ROL_ADMIN;
        $role->description = 'rol administrador';
        $role->save();
    }
}
