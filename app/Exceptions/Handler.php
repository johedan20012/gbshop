<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;

use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Editado por kevin https://pusher.com/tutorials/multiple-authentication-guards-laravel
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if (($request->is('admin') || $request->is('admin/*') ) && (!Auth::guard('cliente')->check())) {
            return redirect()->guest('/loginAdmin');
        }
        $urlo = $request->session()->get('url');
        //dd(route('confirmCompra'));
        //dd($request->getRequestUri());
        //dd($request->url());
        if($request->url() == route('confirmCompra')){
            $urlo = 1;
        }else{
            $urlo = 0;
        }
        
        return redirect()->route('registro',["urlsig"=>$urlo]);
    }
}
