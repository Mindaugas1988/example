<?php

namespace App\Http\Middleware;

use Cookie;
use Closure;
use App;

class setLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Cookie::get('language')!== null) {
            App::setLocale(Cookie::get('language'));
        }else{
            App::setLocale('lt');
        }
        return $next($request);
    }
}
