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
 
 /**
 * @OA\Get(
 *     path="/api/users",
 *     security={{"bearerAuth":{}}},
 *     summary="Get list of users",
 *     @OA\Parameter(
 *         name="page",
 *         description="Pagination page",
 *         in="query",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(response="200", description="User Collection", @OA\JsonContent())
 * )
 */


    public function index()
    {
        $this->authorize('view', 'users');
       return UserResource::collection(User::with('role')->paginate(15));
    }
/**
 * @OA\Post(
 *     path="/api/users/",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response="201" ,
 *        description="User",
 *         ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
 *     )
 * )
 */
    public function store(UserCreateRequest $request)
    {
        $this->authorize('edit', 'users');
       $user = User::create($request->only('first_name','last_name','email','role_id')+
       ['password'=>Hash::make(1234)]);

       return response(new UserResource($user) , Response::HTTP_CREATED );
    }

 /**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     security={{"bearerAuth":{}}},
 *     summary="Get list of users",
 *     @OA\Parameter(
 *         name="id",
 *         description="user id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(response="200", description="User Collection", @OA\JsonContent())
 * )
 */
    public function show($id)
    {
        $this->authorize('view', 'users');
        return new UserResource(User::with('role')->find($id));
    }

 /**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response="202" ,
 *        description="User"),
 *     @OA\Parameter(
 *         name="id",
 *         description="user id",
 *         in="path",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
 *     )
 * )
 */

    public function update(UserUpdateRequest $request, $id)
    {
        $this->authorize('edit', 'users');
        $user = User::find($id);
        $user->update($request->only('first_name','last_name','email','role_id'));
        return response(new UserResource($user) , Response::HTTP_ACCEPTED);
    }

 /**
 * @OA\Delete(
 *     path="/api/users/{id}",
 *     security={{"bearerAuth":{}}},
 *     summary="Delete of user",
 *     @OA\Parameter(
 *         name="id",
 *         description="user id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(response="204", description="User Collection", @OA\JsonContent())
 * )
 */
    public function destroy($id)
    {
       $this->authorize('edit', 'users');
       User::destroy($id);
       return response(null , Response::HTTP_NO_CONTENT );
    }
}
