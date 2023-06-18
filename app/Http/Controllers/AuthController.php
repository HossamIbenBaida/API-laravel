<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
           // 'password_confirm' => Hash::make($request->input('password_confirm')),
            
        ]);
        return response($user , Response::HTTP_CREATED);
    }
    public function login(Request $request){
        if(!Auth::attempt($request->only('email','password'))){
            return \response([
                'error'=>'invalid credentials'
            ] , Response::HTTP_UNAUTHORIZED);
        }
        /**@var User $user */
        $user = Auth::user();
        $jwt = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt',$jwt,60*24);
        return \response([
            'jwt'=>$jwt
        ])->withCookie($cookie);
    }

    public function user(Request $request){
        return $request->user();
    }
    public function logout(){
        $cookie = Cookie::forget('jwt');
        return response([
            'message'=>'success'
        ])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request){
        $user = $request->user();
        $user->update($request->only('first_name','last_name','email'));
        return response($user , Response::HTTP_ACCEPTED);
    }
    public function updatePassword(UpdatePasswordInfo $request){
        $user = $request->user();
        $user->update(['password' => Hash::make($request->input('password'))]);
        return response($user , Response::HTTP_ACCEPTED);
    }
}
