<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
  
    public function index()
    {
       return UserResource::collection(User::with('role')->paginate(15));
    }

  
    public function store(UserCreateRequest $request)
    {
       $user = User::create($request->only('first_name','last_name','email','role_id')+
       ['password'=>Hash::make(1234)]);

       return response(new UserResource($user) , Response::HTTP_CREATED );
    }

 
    public function show($id)
    {
        return new UserResource(User::with('role')->find($id));
    }

 
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->only('first_name','last_name','email','role_id'));
        return response(new UserResource($user) , Response::HTTP_ACCEPTED);
    }

 
    public function destroy($id)
    {
       User::destroy($id);
       return response(null , Response::HTTP_NO_CONTENT );
    }
}
