<?php

namespace App\Services\Application;

class ApplicationService{
    static public function responseFormat($data , $flag = true , $message = 'OK' , $code = 0){
        $data = ApplicationService::removeNullValue($data);
        $response = [
            'response' => $data,
            'flag' => $flag,
            'message' => $message,
            'code'=>$code,
        ];
        return response()->json($response);
    }

    static public function jsonFormat($data , $flag = true , $message = 'OK' , $code = 0){
        $data = ApplicationService::removeNullValue($data);
        $response = [
            'response' => $data,
            'flag' => $flag,
            'message' => $message,
            'code'=>$code,
        ];
        return json_encode($response);
    }

    static function removeNullValue(array $data) : array
    {
        $filteredData = $data;
        foreach ($filteredData as $key => $value) {
            if(is_array($value)){
                $filteredData[$key] = ApplicationService::removeNullValue($value);
            }else{
                if($value === null){
                    $filteredData[$key] = '';
                }
            }
        }
        return $filteredData;
    }
}
