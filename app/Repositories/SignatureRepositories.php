<?php

namespace App\Repositories;

use App\Models\Signature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SignatureRepositories
{
    static public function put($file)
    {
        $sig = Signature::where('user_id', Auth::user()->id)->first();
        if ($sig) {
            //            Storage::delete($sig->signature);
            $path = Storage::disk('local')->putFile('/signatures', $file);
            $sig->signature = $path;
            $sig->save();
        } else {
            $path = Storage::disk('local')->putFile('/signatures', $file);
            $sig = Signature::create([
                'user_id' => Auth::user()->id,
                'signature' => $path
            ]);
        }
        return $path;
    }

    static public function getBase64($user_id)
    {
        $signature = DB::table('user_signature')->where('user_id' , $user_id)->first();
        if(!$signature){
            return null;
        }
        $signature = $signature->signature;
        $signature = storage_path('app/' . $signature);
        if(!file_exists($signature)){
            return null;
        }
        $signature = base64_encode(file_get_contents($signature));
        $signature = $signature;
        return $signature;
    }

    static function getBase64ّFromPath($path){
        $signature = storage_path('app/' . $path);
        if(!file_exists($signature)){
            return null;
        }
        $signature = base64_encode(file_get_contents($signature));
        return $signature;
    }
}
