<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     */
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Build some session info (optional for debugging)
        $session = [
            'session_id'   => session()->getId(),
            'login_time'   => session('login_time', now()),
            'session_age'  => now()->diffInSeconds(session('login_time', now())),
        ];

       
         $stats = [
                'total_students' => Student::count(),
                'total_users' => User::count(),
        ];

        return view('dashboard', compact('user', 'session', 'stats'));


        // Return the dashboard view
    }
}

