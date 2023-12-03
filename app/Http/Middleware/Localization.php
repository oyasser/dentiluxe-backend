<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestLocal = strtolower($request->header('Accept-Language'));

        $local = ($request->hasHeader('Accept-Language') && in_array($requestLocal, ['ar','en'])) ?
            $requestLocal : app()->getLocale();

        app()->setLocale($local);

        return $next($request);
    }
}
