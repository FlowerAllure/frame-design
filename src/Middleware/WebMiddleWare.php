<?php

namespace App\Middleware;

use Closure;

class WebMiddleWare
{
    public function handle($request, Closure $next)
    {
        echo 'web middleware';

        return $next($request);
    }
}
