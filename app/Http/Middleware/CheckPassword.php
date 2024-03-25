<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;

class CheckPassword
{
    use GeneralTrait;
    public function handle(Request $request, Closure $next)
    {
        if ($request->api_password !== env('API_PASSWORD')) {
            return $this->returnError("You'r not enable To entre here");
        }
        return $next($request);
    }
}
