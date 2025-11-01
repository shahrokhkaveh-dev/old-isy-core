<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\SetFirebaseRequest;
use App\Services\Application\ApplicationService;
use App\Services\Notifications\FirebaseService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function setFirebase(SetFirebaseRequest $request): \Illuminate\Http\JsonResponse
    {
        $fcmToken = $request->input('firebase_token');
        $firebaseService = new FirebaseService();
        $user = auth('sanctum')->user();

        $user->firebaseToken()->updateOrCreate(
            ['user_id' => $user->id],
            ['token' => $fcmToken]
        );

        return ApplicationService::responseFormat(
            [],
            true,
            __('messages.firebase_token_registered')
        );
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $user = auth('sanctum')->user();
        $user->firebaseToken()->delete();
        $user->tokens()->delete();

        return ApplicationService::responseFormat(
            [],
            true,
            __('messages.logged_out')
        );
    }

    public function removeFirebase(): \Illuminate\Http\JsonResponse
    {
        $user = auth('sanctum')->user();
        $user->firebaseToken()->delete();

        return ApplicationService::responseFormat(
            [],
            true,
            __('messages.firebase_token_removed')
        );
    }
}
