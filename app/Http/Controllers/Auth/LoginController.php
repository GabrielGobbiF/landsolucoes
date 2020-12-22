<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $login_type = filter_var($request->input('email_or_username'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('email_or_username')
        ]);

        if (Auth::attempt($request->only($login_type, 'password'))) {

            if (Auth::check() && Auth::user()->password_verified == 'N') {

                return redirect()->route('password.change');
            }

            return redirect()->intended($this->redirectPath());
        }

        if (Auth::check()) {

            if (Auth::user()->password_verified == 'N') {

                return redirect()->route('password.change');
            }

            return redirect('/');
        }

        return redirect('/login')
            ->with('error', 'These credentials do not match our records.');

        exit();
        abort(404);

        //$field = filter_var($request->input('email_or_username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        //$request->merge([$field => $request->input('email_or_username')]);
        //if (Auth::attempt($request->only($login_type, 'password'))) {
        //    return redirect()->intended($this->redirectPath());
        //}
        //$attemptLogin = $this->guard()->attempt(
        //    $this->credentials($request),
        //    $request->filled('remember')
        //);
        //if ($attemptLogin) {
        //    return $this->sendLoginResponse($request);
        //}

    }
}
