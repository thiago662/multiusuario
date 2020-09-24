<?php

namespace App\Exceptions;

use App\Http\Middleware\Authenticate;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Support\Arr;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function unauthenticated($request, AuthenticationException $exception){
        if($request->expectsJson()){

            return response()->json(['message'=>$exception->getMessage()],401);
            
        }

        $guard = Arr::get($exception->guards(), 0);

        switch($guard){
            case 'admin':
                $login = "admin.login";
                break;
            case 'web':
                $login = "login";
                break;
            default:
                $login = "login";
                break;
        }

        //return response("oi ".$guard);
        return redirect()->guest(route($login));
    }
}