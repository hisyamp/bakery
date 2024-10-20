<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // dd('aa');

        return User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'provinsi' => $data['provinsi'],
            'instansi' => $data['instansi'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function regis(Request $request)
    {
        $nama = $request->nama;
        $nohp = $request->nohp;
        $email = $request->email;
        $provinsi = $request->provinsi;
        $instansi = $request->instansi;
        $password = Hash::make($request->password);

        $user = User::create([
            "nama" => $nama,
            "nohp" => $nohp,
            "email" => $email,
            "member" => 0,
            "instansi" => $instansi,
            "provinsi" => $provinsi,
            "password" => $password
        ]);

        $user->sendEmailVerificationNotification();
        
        $resp = [
            "status" => "200",
            "message" => "Registrasi Berhasil !"
        ];
        // return $user;

        return response()->json($resp);
    }


}
