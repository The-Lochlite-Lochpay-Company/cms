<?php

namespace Lochlite\cms\App\Requests\Auth;

use Lochlite\cms\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
		$request = $this->only('email', 'password');
		$email = $request['email'];
		$password = $request['password'];
		$user = User::where('email', $email)->orWhere('phone', $email)->orWhere('social_security', $email)->first();
        if (!Auth::attempt(['email' => $user == null ? null : $user->email, 'password' => $password], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
			
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        RateLimiter::clear($this->throttleKey());

    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }
        Lochlitecms::setHistory($action = 'lockout ', $description = 'The user was temporarily blocked due to too many attempts on the day: ' . now(), $this->user);

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
