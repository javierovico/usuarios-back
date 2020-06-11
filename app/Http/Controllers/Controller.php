<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $abortar
     * @param array $rols
     * @return bool
     * Para validar los roles de un usuario
     */
    public function autorizar($abortar,...$rols){
        /** @var User $user */
        $user = $this->getUser();
        if(!$user){
            $abortar && abort(401,"tenes que iniciar sesion");
            return false;
        }else if(!$user->hasAnyRole($rols)){
            $rolString = is_array($rols)?(implode(' o ',$rols)):$rols;
            $abortar && abort(401,"Necesitas roles de $rolString");
            return false;
        }else{
            return true;
        }
    }

    public function getUser(){
        $user =  Auth::user()?Auth::user():auth('api')->user();      //obtiene el usuario autenticado
        if(!$user){
            abort(403,'No autenticado');
        }
        return $user;
    }
}
