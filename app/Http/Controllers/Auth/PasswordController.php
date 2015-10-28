<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    protected  $redirectPath= '/auth/login';
    use ResetsPasswords;
    /**
     * @var PasswordBroker
     */
    private $passwordBroker;
    /**
     * @var Guard
     */
    private $guard;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(PasswordBroker $passwordBroker,Guard $guard)
    {
        $this->middleware('guest');
        $this->passwordBroker = $passwordBroker;
        $this->guard = $guard;
    }

    public function postReset(Request $request){
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        //dd($this->passwordBroker);
        $response = $this->passwordBroker->reset($credentials, function($user, $password)
        {
            $user->password = bcrypt($password);

            $user->save();

            $this->guard->login($user);
        });

        switch ($response)
        {
            case PasswordBroker::PASSWORD_RESET:
                return redirect($this->redirectPath());

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }

    }
}
