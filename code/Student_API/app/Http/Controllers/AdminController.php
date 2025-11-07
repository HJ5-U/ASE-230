<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'recent_registrations' => User::where('created_at', '>=', now()->subWeek())->count(),
            'recent_logins' => User::where('last_login', '>=', now()->startOfDay())->count(),
        ];

        return view('admin.index', compact('users', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|in:activate,deactivate',
        ]);

        $current = auth()->user();

        if ($request->user_id == $current->id && $request->action === 'deactivate') {
            return redirect()->back()->with('error', 'You cannot deactivate your own account.');
        }

        $target = User::findOrFail($request->user_id);
        $target->is_active = $request->action === 'activate';
        $target->save();

        return redirect()->back()->with('success', 'User ' . ($target->is_active ? 'activated' : 'deactivated') . ' successfully.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted');
    }
}
