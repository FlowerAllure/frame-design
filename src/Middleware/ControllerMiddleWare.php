<?php

namespace App\Middleware;

use Closure;
use Psr\Http\Message\RequestInterface;

class ControllerMiddleWare
{
    public function handle(RequestInterface $request, Closure $next)
    {
        echo '<hr/>controller middleware<hr/>';

        return $next($request);
    }
}
