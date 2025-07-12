<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan ini
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();

            Log::info('Session active before regenerate: ' . (session()->isStarted() ? 'Yes' : 'No')); // Ganti \Log dengan Log
            Log::info('Session ID before regenerate: ' . session()->getId());

            session()->regenerate();

            Log::info('Session regenerated successfully. New Session ID: ' . session()->getId());

            if (Auth::user()->usertype === 'admin') {
                Log::info('Redirecting to admin.dashboard');
                return redirect()->route('admin.dashboard');
            }

            Log::info('Redirecting to dashboard');
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            throw $e;
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
