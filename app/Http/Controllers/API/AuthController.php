<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\StoreRegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(StoreRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('assets/profile-pictures');
        }

        if ($request->hasFile('ktp')) {
            $data['ktp'] = $request->file('ktp')->store('assets/ktps');
            $data['email_verified_at'] = now();
        }

        DB::beginTransaction();
        try {
            $user = User::create($data);
            $user->wallet()->create($data);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['message' => $th->getMessage()], 500);
        }

        return response()->json(UserResource::make($user), 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = JWTAuth::attempt($request->validated())) {
            return response()->json(['message' => 'These credentials do not match our records.'], 422);
        }

        return response()->json([
            'user' => UserResource::make(auth()->user()->with('wallet')->first()),
            'token' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ], 200);
    }
}
