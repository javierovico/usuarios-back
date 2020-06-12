<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     * Lista los usuarios actuales (los pagina)
     * SOlo un usuario con rol de admin puede hacer esto
     */
    public function index(Request $request){
        $request->validate([
            'cantidad' => 'integer|max:40',    //por pagina
            'page'=>'integer',          //pagina actual
            'id' => 'integer',          //para busqueda
        ]);
        $this->autorizar(true,'admin');
        $query = User::query();
        if($userId = $request->get('id')){
            $query = $query->where('id',$userId);
        }
        return $query->paginate($request->get('cantidad',20),['*'],'page',$request->get('page',1));
    }

    public function store(Request $request){
        return response(['success' => false, 'message' => 'Para agregar un nuevo usuario, debe acceder por '.env('APP_URL').'api/auth/signup'],300);
    }

    public function update(Request $request, $id){
        /** @var User $userEdit */
        $userEdit = User::findOrFail($id);
        if($userEdit->id != $this->getUser()->id && !$this->autorizar(false,'admin')){
            abort(401,"No siendo admin solo podes editar tu propio id: ".$this->getUser()->id);
        }else{
            $request->validate([
                'first_name' => 'string|max:200',
                'last_name' => 'string|max:200',
                'username' => 'string|max:200',
                'name'     => 'string|max:200',
                'email'    => 'string|email|max:200',
                'password' => 'string',
                'rols' => ''
            ]);
            if($request->get('first_name')){
                $userEdit->first_name = $request->first_name;
            }
            if($request->get('last_name')){
                $userEdit->last_name = $request->last_name;
            }
            if($request->get('username')){
                $userEdit->username = $request->username;
            }
            if($request->get('name')){
                $userEdit->name = $request->name;
            }
            if($request->get('email')){
                $userEdit->email = $request->email;
            }
            if($request->get('password')){
                $userEdit->password = bcrypt($request->password);
            }
            if(($rols = $request->get('rols')) && $this->getUser()->hasAnyRole('admin') && is_array($rols)){ //solo un admin puede asignar roles
                foreach ($rols as $rol=>$val){
                    $userEdit->setRol($rol,$val);
                }
            }
            $userEdit->save();
        }
        $userEdit->refresh();
        return $userEdit;
    }

    public function destroy(Request $request, $id){
        $userEdit = User::findOrFail($id);
        if($userEdit->id != $this->getUser()->id && !$this->autorizar(false,'admin')){
            abort(401,"No siendo admin solo podes eliminar tu propio user: ".$this->getUser()->id);
        }else{
            $userEdit->delete();
        }
        return ['success' => true, 'message' => sprintf("El usuario %s fue eliminado",$userEdit->username)];
    }

    public function show(Request $request, $id){
        $userEdit = User::findOrFail($id);
        if($userEdit->id != $this->getUser()->id && !$this->autorizar(false,'admin')){
            abort(401,"No siendo admin solo podes editar tu propio id: ".$this->getUser()->id);
        }else{
            return $userEdit;
        }
    }
}
