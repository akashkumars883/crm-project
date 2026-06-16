<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    // protected function redirectTo()
    // {
    //     if (auth()->user()->hasRole('admin')) {
    //         return route('admin.dashboard');
    //     } elseif (auth()->user()->hasRole('manager')) {
    //         return route('manager.dashboard');
    //     } elseif (auth()->user()->hasRole('supervisor')) {
    //         return route('supervisor.dashboard');
    //     } elseif (auth()->user()->hasRole('accounts')) {
    //         return route('accounts.dashboard');
    //     } elseif (auth()->user()->hasRole('hr')) {
    //         return route('hr.dashboard');
    //     } elseif (auth()->user()->hasRole('employee')) {
    //         return route('employee.dashboard');
    //     } elseif (auth()->user()->hasRole('vendor')) {
    //         return route('vendor.dashboard');
    //     } elseif (auth()->user()->hasRole('client')) {
    //         return route('client.dashboard');
    //     }

    //     return $this->redirectTo;
    // }
}
