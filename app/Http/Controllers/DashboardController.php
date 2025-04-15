<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $roles = $user->getRoleNames(); // Mendapatkan nama-nama role

        return view('administrator.dashboard', compact('user', 'roles'));
    }

    /**
     * Menampilkan tampilan utama dashboard (misalnya setelah login).
     */
    public function index()
    {
        // Jika pengguna login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // Jika tidak login, arahkan ke halaman login
        return redirect()->route('login');
    }
}
