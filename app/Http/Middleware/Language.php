<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    public function handle($request, Closure $next)
    {
        if($request->session()->has('language')){
            App::setLocale($request->session()->get('language'));
        }else{
            App::setLocale(config('app.fallback_locale'));
        }
        return $next($request);
    }
}
