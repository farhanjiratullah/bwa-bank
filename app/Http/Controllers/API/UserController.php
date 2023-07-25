<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = auth()->user()->with('wallet')->first();

        return response()->json($user);
    }

    public function getUsersByUsername(Request $request, $username)
    {
        $users = User::select([
            'id', 'name', 'username', 'email_verified_at', 'profile_picture'
        ])
            ->where('username', 'like', "%{$username}%")
            ->whereNot('id', auth()->id())
            ->get();

        return response()->json($users);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($data['current_password'] && $data['password']) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return response()->json(['message' => 'The current password is incorrect'], 422);
            }

            $data['password'] = Hash::make($data['password']);
        }

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('assets/profile-pictures');

            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }
        }

        if ($request->hasFile('ktp')) {
            $data['ktp'] = $request->file('ktp')->store('assets/ktps');
            $data['email_verified_at'] = now();

            if ($user->ktp) {
                Storage::delete($user->ktp);
            }
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully']);
    }
}
