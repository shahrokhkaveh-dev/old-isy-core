<?php

namespace App\Services\ApiKey\Auth;

use Illuminate\Http\JsonResponse;

interface ApiKeyAuthInterface
{
    public function login(string $phone): JsonResponse;
    public function register(string $phone): JsonResponse;
}
