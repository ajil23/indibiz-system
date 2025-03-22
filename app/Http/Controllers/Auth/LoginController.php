<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware('auth')->only('logout');
    }

    public function index()
    {
        if ($user = Auth::user()) {
            if ($user->role == 'admin') {
                return redirect()->intended('admin');
            } elseif ($user->role == 'pimpinan') {
                return redirect()->intended('pimpinan');
            } elseif ($user->role == 'sales') {
                return redirect()->intended('sales');
            }
        }
        return view('login');
    }

    public function prosesLogin(Request $request)
    {
        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $kredensial = $request->only('email', 'password');
        if (Auth::attempt($kredensial)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->intended('admin');
            } elseif ($user->role == 'pimpinan') {
                return redirect()->intended('pimpinan');
            } elseif ($user->role == 'sales') {
                return redirect()->intended('sales');
            }
            return redirect()->intended('/');
        }
        return redirect('login')
        ->withInput()
        ->withErrors(['login_gagal' => 'data tidak cocok']);
    }
}
