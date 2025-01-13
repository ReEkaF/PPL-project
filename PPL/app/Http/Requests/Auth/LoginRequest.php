<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                // 'required',
                // 'digits:12', // hanya menerima huruf dan angka
            ],
            'password' => [
                'required',
                // 'string',
                // 'min:8',      // minimal 8 karakter
                // 'max:20',    // maksimal 255 karakter
                // 'regex:/[a-z]/',    // harus memiliki setidaknya satu huruf kecil
                // 'regex:/[A-Z]/',    // harus memiliki setidaknya satu huruf besar
                // 'regex:/[0-9]/',    // harus memiliki setidaknya satu angka
            ],
        ];

    }


    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.digits' => 'Username harus berisi tepat 12 angka.',

            'password.required' => 'Password wajib diisi.',
            // 'password.string' => 'Password harus berupa string.',
            // 'password.min' => 'Password minimal harus terdiri dari 8 karakter.',
            // 'password.max' => 'Password maksimal terdiri dari 20 karakter.',
            // 'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
        ];
    }


    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('username')).'|'.$this->ip());
    }

    // public function redirectTo()
    // {
    //     return '/';
    // }
}
