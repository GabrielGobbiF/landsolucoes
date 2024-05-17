<?php

namespace App\Http\Controllers\Auth\Clients;

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
    protected $redirectTo = '/clientes/obras';

    protected $guard = 'clients';

    protected $username = 'username';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::guard($this->guard)->check()) {
            return redirect('/clientes/obras');
        }

        return view('auth.clients.login');
    }

    public function login(Request $request)
    {
        $login_type = filter_var($request->input('email_or_username'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => mb_strtolower($request->input('email_or_username'), 'UTF-8')
        ]);

        if (Auth::guard($this->guard)->attempt($request->only($login_type, 'password'))) {
            return redirect('/clientes/obras');
        }

        if (Auth::guard($this->guard)->check()) {
            return redirect('/clientes/obras');
        }

        return redirect('/clientes/login')
            ->with('error', 'Login ou senha incorretos.');
    }
}
