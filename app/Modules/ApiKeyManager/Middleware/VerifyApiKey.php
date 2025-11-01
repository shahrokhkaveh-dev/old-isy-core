<?php

namespace App\Modules\ApiKeyManager\Middleware;

use App\Modules\ApiKeyManager\Enumerations\ApiKeyReceivedFields;
use App\Modules\ApiKeyManager\Models\ApiKeyIssued;
use App\Modules\ApiKeyManager\Models\ApiKeyReceived;
use App\Modules\ApiKeyManager\Service\ApiKeyLogService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    protected ApiKeyLogService $apiKeyLogService;

    public function __construct(ApiKeyLogService $apiKeyLogService)
    {
        $this->apiKeyLogService = $apiKeyLogService;
    }
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');
        if (!$apiKey) {
            return response()->json(['message' => 'API key is missing'], 401);
        }
        $validKey = ApiKeyIssued::all()->first(function ($record) use ($apiKey) {
            return Crypt::decryptString($record->getAttribute(ApiKeyReceivedFields::API_KEY->value)) === $apiKey;
        });
        if (!$validKey) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }
        $this->apiKeyLogService->logRequest($apiKey, $request->path(), $request->ip());
        return $next($request);
    }
}
