<?php

namespace App\Controller;

use App\Middleware\ControllerMiddleWare;
use Core\Controller;
use Psr\Http\Message\RequestInterface;

class UserController extends Controller
{
    protected array $middleware = [ // 这个控制器的中间件
        ControllerMiddleWare::class,
    ];

    public function index(RequestInterface $request): array
    {
        return [
            'method' => $request->getMethod(),
            'url' => $request->getUri(),
        ];
    }
}
