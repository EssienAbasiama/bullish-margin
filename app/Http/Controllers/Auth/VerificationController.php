<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\VerifiesEmails;


// use Illuminate\Support\Facades\Mail;
// use App\Mail\VerificationCodeMail;

// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;

// use Illuminate\Foundation\Auth\RegistersUsers;

class VerificationController extends Controller
{

    public function verifyEmail(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'verification_code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if verification code matches
        if ($user->verification_code === $request->verification_code) {
            // Update the user's verified status to true
            $user->update([
                'verified' => true,
                'email_verified_at' => now(), // Set the verification time
                'verification_code' => null, // Clear the verification code after successful verification
            ]);

            return response()->json(['message' => 'Email verified successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid verification code'], 422);
        }
    }
}
