<?php

namespace App\Http\Middleware;

use App\Services\Application\ApplicationService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class ApplicationAuthenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        return abort(401);
    }
}
