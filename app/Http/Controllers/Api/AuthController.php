<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param UserRegisterRequest $request
     * @return Response
     */
    public function register(UserRegisterRequest $request): Response
    {
        $user = User::create($request->validated());

        $token = $user->createToken('events-app')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    /**
     * @param LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)) {
            return response([
                'message' => 'Wrong credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('events-app')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token
        ], Response::HTTP_CREATED);

    }

    /**
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        $request->user()->tokens()->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
