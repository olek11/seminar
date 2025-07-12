<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // Pastikan ini ada

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $credentials = $this->validated();

        if (Auth::attempt($credentials)) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function ensureIsNotRateLimited(): void
    {
        Log::info('Checking rate limit for throttle key: ' . $this->throttleKey());
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            Log::info('Rate limit not exceeded');
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());
        Log::warning('Rate limit exceeded, locking out for ' . $seconds . ' seconds');

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        $email = $this->input('email', ''); // Pastikan input() digunakan
        Log::debug('Email value for throttle key: ' . $email); // Debugging
        $clientIp = $this->getClientIp() ?: request()->ip() ?: '127.0.0.1'; // Fallback ke request()->ip()
        Log::debug('Client IP for throttle key: ' . $clientIp); // Debugging
        return Str::transliterate(Str::lower($email) . '|' . $clientIp);
    }
}
