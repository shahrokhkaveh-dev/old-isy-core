<?php

namespace App\Http\Controllers\Auth\ApiKey;

use App\Http\Controllers\Controller;
use App\Services\ApiKey\Auth\Sanatyariranian;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;

class LoginToAnotherController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->only('source_site');
        if (!isset($validatedData['source_site']) || !is_string($validatedData['source_site'])) {
            return ApplicationService::responseFormat([
                [],
                false,
                'سایت مقصد الزامی است'
            ]);
        }
        $sourceSite = $validatedData['source_site'];
        if($sourceSite == 'sanatyariranian.ir'){
            $service = new Sanatyariranian();
            $phone = auth('sanctum')->user()->phone;
            return $service->login($phone);
        }
        return ApplicationService::responseFormat([], false, 'سایت مورد نظر نامعتبر است');
    }
}
