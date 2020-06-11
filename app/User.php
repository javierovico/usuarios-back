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
 * @property string first_name
 * @property string last_name
 * @property string name
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * @var string[]
     * Para cargar siempre los roles de un usuario
     */
    protected $with = ['rols'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','first_name','last_name'
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

    public function rols(){
        return $this->belongsToMany(Rol::class)->withTimestamps();
    }


    /**
     * @param $rol string : nombre del rol a alterar
     * @param $val boolean : true: agregar, false: remover
     */
    public function setRol($rol, $val){
        if($val){
            $this->addRol($rol);
        }else{
            $this->remRol($rol);
        }
    }

    /**
     * @param mixed ...$rols recibe un array de string que representan la clave primaria de un rol
     * @throws ModelNotFoundException
     */
    public function addRol(... $rols){
        foreach ($rols as $rol){
            $this->remRol($rol);
            $this->rols()->attach(Rol::query()->where('name', $rol)->firstOrFail()); //si no encuentra, lanza exception
        }
    }

    /**
     * @param mixed ...$rols
     */
    public function remRol(... $rols){
        foreach ($rols as $rol){
            $this->rols()->detach(Rol::query()->where('name', $rol)->firstOrFail()); //si no encuentra, lanza exception
        }
    }

    /**
     * @param mixed ...$roles
     * @return bool
     * Retorna true si el usuario tiene al menos uno de los roles recibidos como parametro
     */
    public function hasAnyRole(...$roles){
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role){
        if ($this->rols()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }


}
