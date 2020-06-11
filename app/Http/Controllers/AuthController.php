<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{

    function signup(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'username' => 'required|string|max:200',
            'name'     => 'required|string|max:200',
            'email'    => 'required|string|email|unique:users|max:200',
            'password' => 'required|string|confirmed',
        ]);
        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->save();
        $user->addRol('user');
        return response(['success' => true, 'message' => 'usuario creado'],201);
    }
    public function login(Request $request){
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response(['message' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->get('remember_me',false)) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }else{
            $token->expires_at = Carbon::now()->addHour();
        }
        $token->save();
        return[
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                ->toDateTimeString(),
        ];
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return ['status' => true, 'message' => 'logout success'];
    }

    public function user(Request $request){
        return $request->user();
    }
}
