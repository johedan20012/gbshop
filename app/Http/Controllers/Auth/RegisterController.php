<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:cliente');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function createCliente(Request $request)
    {
        //$this->validator($request->all())->validate();

        $validacion = Validator::make($request->all(), array(
            'registro-nombre' => 'required|string|max:255',
            'registro-correo' => 'required|string|email|max:255|unique:clientes,email',
            'registro-pass' => 'required|string|min:6|confirmed',
        ));
        
        if($validacion->fails()){
            return back()->with('Error' , 'No se completar el registro, puede que el correo ya este registrado');
        }

        $cliente = Cliente::create([
            'nombreCompleto' => $request['registro-nombre'],
            'email' => $request['registro-correo'],
            'password' => bcrypt($request['registro-pass']),
        ]);
        return redirect()->intended('/registro')->with('Mensaje' , 'Registro efectuado con exito, puede proceder a iniciar sesión');
    }

    public function showClienteRegisterForm()
    {
        return view('cliente.registro', ['url' => '/registro']);
    }
}
