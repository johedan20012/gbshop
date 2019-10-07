<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Auth;

use Validator;
use Session;

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

    public function logout(){
        Auth::logout();

        $carrito = session()->get('carrito');
        $productos = session()->get('productos');
        $total = session()->get('total');

        Session::flush();

        session()->put('carrito', $carrito);
        session()->put('productos',$productos);
        session()->put('total',(float)$total);

        return redirect('/');
        //return dd(session()->all());
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
        /*
        $admin = User::whereRaw("BINARY `username`= ?",[$request->username])->first();

        if($admin == null){
            return back()->with('Error','Las credenciales no son validas')->withInput($request->only('username', 'remember'));
        }*/

        Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->get('remember'));
            
        if(Auth::user() != null){
            return redirect()->intended('/admin');
        }

        return back()->with('Error','Las credenciales no son validas')->withInput($request->only('username', 'remember'));
    }

    public function showClienteLoginForm()
    {
        return redirect(route('inicio'));
    }

    public function clienteLogin(Request $request)
    {
        //dd($request);
        $validacion = Validator::make($request->all(), [
            'email'   => 'required|string|email',
            'password' => 'required|min:6',
            'redireccion' => 'nullable|integer|digits_between:1,3'
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

        //Auth::guard('cliente')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));
            
        if(Auth::guard('cliente')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))){//Auth::user() != null){
            $redi = ($request->input('redireccion') !== null)? $request->input('redireccion') : 0;
            if($redi == 1){
                return redirect()->route('confirmCompra');
            }
            return redirect()->intended('/');
        }

        return back()->with('Error','Las credenciales no son validas')->withInput($request->only('email', 'remember'));
    }
}
