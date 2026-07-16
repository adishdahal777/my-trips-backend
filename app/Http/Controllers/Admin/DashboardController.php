<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalTrips' => Trip::count(),
            'activeUsers' => User::whereNotNull('email_verified_at')->count(),
            'recentUsers' => User::latest()->limit(5)->get(),
        ]);
    }
}
