<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Auth;

use Validator;

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
    protected $redirectTo = '/admin';

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
     * Muestra el login para admins
     *
     * @return la vista loginAdmin
     */
    public function showLoginForm()
    {
        if(Auth::check()){
            return redirect(route('admin'));
        }
        return redirect(route('loginAdmin'));
    }

    /**
     * Maneja el loggeo para admins
     *
     * @return la vista /admin en caso de exito, o el error en caso contrario
     */
    public function login(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'username'   => 'required|string',
            'password' => 'required|min:6'
        ]);

        if($validacion->fails()){
            $errores = $validacion->errors();

            $error = "Las credenciales no son validas";

            if($request->username == "" || $request->password == ""){
                $error = "Los campos no pueden estar vacios";
            }else {
                if ($errores->has('password')) {
                    $error = "La contraseña debe tener minimo 6 caracteres";
                }
            }  
            return back()->with('Error',$error)->withInput($request->only('username', 'remember'));
        }
        
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->get('remember'))) {
            
            if(Auth::user()->username == $request->username){
                return redirect()->intended('/admin');
            }

            Auth::logout();
            return back()->with('Error','Las credenciales no son validas')->withInput($request->only('username', 'remember'));

            
        }
        return back()->with('Error','Las credenciales no son validas')->withInput($request->only('username', 'remember'));
    }
}
