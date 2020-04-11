<?php

namespace FederalSt\Http\Controllers\Auth;

use FederalSt\Http\Controllers\Controller;
use FederalSt\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

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
     * Defini para onde devo redirecionar o usuario autenticado.
     * @return string
     */
    public function redirectTo()
    {
        return \Auth::user()->role == User::ROLE_ADMIN ? '/admin/home' : 'home';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect($request->is('admin/*') ? '/admin/login' : '/login');

    }

}
