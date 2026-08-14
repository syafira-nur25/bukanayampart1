<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Proses autentikasi
        $request->authenticate();

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika user adalah admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Jika user adalah manpower
        if ($user->role === 'manpower') {
            return redirect()->route('manpower.dashboard');
        }

        // Jika role tidak dikenali
        Auth::logout();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Role pengguna tidak dikenali.',
            ]);
    }

    /**
     * Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
