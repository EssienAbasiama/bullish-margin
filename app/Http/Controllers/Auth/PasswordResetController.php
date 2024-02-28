<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        // Check if the user is verified
        if (!$user->verified) {
            return response()->json(['message' => 'You need to be verified before accessing this endpoint.'], 403);
        }

        // Update the password
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function updatePasswordByEmail(UpdatePasswordRequest $request)
    {
        // Find user by email
        $user = User::where('email', $request->input('email'))->first();

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check if the user is verified
        if (!$user->verified) {
            return response()->json(['message' => 'User is not verified.'], 403);
        }

        // Update the password
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }
}
