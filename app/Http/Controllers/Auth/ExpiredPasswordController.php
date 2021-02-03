<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordExpiredRequest;

class ExpiredPasswordController extends Controller
{

    public function expired()
    {
        return view('auth.passwords.expired');
    }

    public function change()
    {
        return view('auth.change-password');
    }

    public function postExpired(PasswordExpiredRequest $request)
    {
        $request->user()->update([
            'password' => bcrypt($request->password),
            'password_verified' => 'Y',
            'rg' => $request->rg
        ]);

        return redirect()->intended('/');
    }
}
