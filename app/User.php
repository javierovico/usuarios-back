<?php

namespace App;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property string username
 * @property string email
 * @property string password
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Rol::class)->withTimestamps();
    }

    /**
     * @param mixed ...$rols recibe un array de string que representan la clave primaria de un rol
     * @throws ModelNotFoundException
     */
    public function addRol(... $rols){
        foreach ($rols as $rol){
            $this->roles()->attach(Rol::query()->where('name', $rol)->firstOrFail()); //si no encuentra, lanza exception
        }
    }
}
