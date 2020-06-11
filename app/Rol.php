<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string description
 */
class Rol extends Model
{
    //
    const NOMBRE_ROL_USER = 'user';
    const NOMBRE_ROL_ADMIN = 'admin';
}
