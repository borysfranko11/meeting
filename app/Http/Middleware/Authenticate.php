<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     */
    public function __construct( Guard $auth )
    {
        $this -> auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        $sessions = $request -> session() -> all();

        if( !empty( $sessions["user"] ) )
        {
            return $next( $request );
        }
        else
        {
            if( $request -> ajax() )
            {
                return response( 'Unauthorized.', 401 );
            }
            else
            {
                $now_url_class = explode('/',$_SERVER['REQUEST_URI']);

                if(in_array('wap',$now_url_class)){
                    session( ["user_wap_url" => $_SERVER['REQUEST_URI']] );
                }

                return redirect( 'Login/index' );
            }
        }
    }
}
