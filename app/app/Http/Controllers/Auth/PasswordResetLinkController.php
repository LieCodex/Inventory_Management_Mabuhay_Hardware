<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetApproval;
use Illuminate\Http\Request;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request)
    {
        // 1. Validate the email exists
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        // 2. Find the user
        $user = User::where('email', $request->email)->first();

        // 3. Log the pending request for the admin
        PasswordResetApproval::updateOrCreate(
            ['user_id' => $user->id],
            ['status' => 'pending']
        );

        // 4. Return back to the login page with a success message
        return back()->with('status', 'Your password reset request has been sent to the admin for approval.');
    }
}