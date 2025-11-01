<?php

namespace App\Services\ApiKey\Auth;

use App\Models\User;
use App\Modules\ApiKeyManager\Enumerations\ApiKeyReceivedFields;
use App\Modules\ApiKeyManager\Models\ApiKeyReceived;
use App\Services\Application\ApplicationService;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class Sanatyariranian implements ApiKeyAuthInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $apiKey = ApiKeyReceived::where(ApiKeyReceivedFields::SOURCE_SITE->value, 'https://sanatyariranian.ir')->first();
        if($apiKey) {
            $this->apiKey = $apiKey->getAttribute(ApiKeyReceivedFields::API_KEY->value);
        }else{
            abort(500, 'API key not found');
        }
    }

    public function login(string $phone): JsonResponse
    {
        $client = new Client();

        $response = $client->post('https://app.sanatyariranian.ir/api/api-key-auth/register-or-login',[
            'headers' => [
                'Content-Type' => 'application/json',
                'X-API-KEY' => $this->apiKey
            ],
            'json' => [
                'phone' => $phone
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(),true);
        if($result['status'] == 'login'){
            return ApplicationService::responseFormat(
                [
                    'token'=> $result['token'],
                ]
            );
        }
        if($result['status'] == 'register'){
            return self::register($phone);
        }
        return ApplicationService::responseFormat([], false, 'ورود ناموفق');
    }

    public function register(string $phone): JsonResponse
    {
        $user = User::where('phone', $phone)->first();
        if($user){
            $client = new Client();
            $response = $client->post('https://app.sanatyariranian.ir/api/api-key-auth/register',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-KEY' => $this->apiKey
                ],
                'json' => [
                    'name' => $user->name,
                    'username' => $user->nationaliy_code ?? $user->phone,
                    'email' => $user->email,
                    'password' => $user->nationaliy_code ?? $user->phone ?? '',
                    'phone' => $phone,
                    ]
                ]);
            $result = json_decode($response->getBody()->getContents(),true);
            if($result['status'] == 'login'){
                return ApplicationService::responseFormat(
                    [
                        'token'=> $result['token'],
                    ]
                );
            }
        }
        return ApplicationService::responseFormat([], false, 'ثبت نام ناموفق');
    }
}
