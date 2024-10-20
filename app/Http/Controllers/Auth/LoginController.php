<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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

    public function formLogin(){

		return view('auth.login');
	}

    public function postLogin(Request $request){
        try {
            // dd($request);
            if(Auth::attempt([
                'username' => $request->email,
                'password' => $request->password,
                'is_active' => '1'
                ])){
                    // $request->session()->regenerate();
                    if(Auth::user()->role_id_id == 1) return redirect('dashboard_admin');
                    else if(Auth::user()->role_id_id == 2) return redirect('dashboard_admin');
                    else return redirect('/');
                
            }else{
                // dd("salah");
                return redirect('/')->with(['warning' => 'Kombinasi Email dan Password anda tidak cocok, silahkan coba lagi']);
            }
            
        }catch (Exception $e) {
            dd($e->getMessage());

            return redirect('/')->with('error', 'ok');
    
        }
		
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->intended(url('/'));
    }
}
