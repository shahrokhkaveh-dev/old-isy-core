<?php

namespace App\Modules\ApiKeyManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ApiKeyManager\Service\ApiKeyService;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    protected ApiKeyService $apiKeyService;
    public function __construct()
    {
        $this->apiKeyService = new ApiKeyService();
    }

    public function generateApiKey(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'target_site' => 'required|string|max:255',
        ]);

        $apiKey = $this->apiKeyService->generateApiKey($request->input('target_site'));
        return response()->json(['api_key' => $apiKey]);
    }

    public function storeReceivedApiKey(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string|max:255',
            'source_site' => 'required|string|max:255',
        ]);

        $this->apiKeyService->storeReceivedApiKey($request->input('api_key'), $request->input('source_site'));
        return response()->json(['message' => 'API key stored successfully']);
    }
}
