<?php

namespace App\Http\Requests\Auth;

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
    public $fieldType='email';
    public $errorType='login_email';
    public $decayMinutes=60;

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
        if(!request()->login_guest)
        {
            return [
                'login_email' => 'required|string',
                'username'=>'sometimes|required',
                'login_password' => 'required|string',
            ];
        }
        return array();
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

        $this->fieldType = filter_var($this->login_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $this->erroyType =  $this->fieldType=='email' ? 'login_email' : 'login_username';
        if (! Auth::attempt(
         array($this->fieldType => $this->login_email,'password' => $this->login_password),
          $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey(),500);
            throw ValidationException::withMessages(
               [$this->erroyType=> __('auth.failed').'<br> Your have '.
               RateLimiter:: retriesLeft($this->throttleKey(),config('auth.max_attempt')).' attempts left',]);
        }
        elseif (!Auth::user()->is_active()){
            throw ValidationException::withMessages(
                ['inactive' =>__('auth.inactive')]
              );
              Auth::logout();
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
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), config('auth.max_attempt'))) {
            return;
        }

            $key = $this->throttleKey();
            $attempts =  RateLimiter::attempts($key);
            RateLimiter::clear($key);
            $this->decayMinutes = $attempts ==1 ? 60 : ($attempts - 1) * 50;
            RateLimiter::hit($key,$this->decayMinutes);
            for ($i = 0; $i < $attempts; $i++) {
                RateLimiter::increasevalue($key);
            }

        event(new Lockout($this));
        $time = RateLimiter::availableIn($this->throttleKey());
        $seconds=$time % 60;
        $minutes=floor($time / 60);
        throw ValidationException::withMessages([
            'login_email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => $minutes,
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
        return Str::lower($this->input($this->fieldType)).'|'.$this->ip();
    }
}
