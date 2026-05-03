<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        
        // Fetch pending requests to display on the dashboard
        $pendingResets = PasswordResetApproval::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        // Make sure 'pendingResets' is included inside the compact() function!
        return view('admin.dashboard', compact('users', 'pendingResets'));
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,cashier,inventory_manager',
        ]);

        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return back()->with('status', 'User created successfully!');
    }

    public function destroyUser(User $user)
    {
        // Prevent admin from deleting themselves
        if (auth()->id() === $user->id) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $user->delete();
        return back()->with('status', 'User deleted successfully.');
    }

    public function approveReset(PasswordResetApproval $approval)
    {
        // Generate the standard Laravel reset token & send email
        $token = Password::getRepository()->create($approval->user);
        $approval->user->sendPasswordResetNotification($token);

        // Mark as approved
        $approval->update(['status' => 'approved']);

        return back()->with('status', 'Password reset approved. Email sent to user.');
    }

    public function rejectReset(PasswordResetApproval $approval)
    {
        $approval->update(['status' => 'rejected']);
        return back()->with('status', 'Password reset request rejected.');
    }
}