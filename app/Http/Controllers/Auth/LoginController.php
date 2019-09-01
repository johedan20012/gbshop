<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Auth;

use Validator;

use App\User;
use App\Cliente;

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
    //protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:cliente')->except('logout');
    }

    /**
     * Muestra el login para admins
     *
     * @return la vista loginAdmin
     */
    public function showLoginForm()
    {
        return redirect(route('getLoginAdmin'));
    }

    /**
     * Maneja el loggeo para admins
     *
     * @return la vista /admin en caso de exito, o el error en caso contrario
     */
    public function login(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            //'username'   => 'required|string',
            'email' => 'required|string|email|unique:clientes,email',
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
        /*
        $admin = User::whereRaw("BINARY `username`= ?",[$request->username])->first();

        if($admin == null){
            return back()->with('Error','Las credenciales no son validas')->withInput($request->only('username', 'remember'));
        }*/

        Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));
            
        if(Auth::user() != null){
            return redirect()->intended('/admin');
        }

        return back()->with('Error','Las credenciales no son validas')->withInput($request->only('email', 'remember'));
    }

    public function showClienteLoginForm()
    {
        return redirect(route('inicio'));
    }

    public function clienteLogin(Request $request)
    {
        
        $validacion = Validator::make($request->all(), [
            'email'   => 'required|string|email',
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
            return back()->with('Error',$error)->withInput($request->only('email', 'remember'));
        }
        /*
        $cliente = Cliente::whereRaw("BINARY `username`= ?",[$request->username])->first();

        if($cliente == null){
            return back()->with('Error','Las credenciales no son validas')->withInput($request->only('username', 'remember'));
        } */

        Auth::guard('cliente')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));
            
        if(Auth::user() != null){
            return redirect()->intended('/');
        }

        return back()->with('Error','Las credenciales no son validas')->withInput($request->only('email', 'remember'));
    }
}
