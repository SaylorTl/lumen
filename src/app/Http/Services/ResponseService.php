<?php

namespace App\Http\Services;
use User\Response as Response;

class ResponseService
{
    public static function success($code=0,$content='',$message='success'){
        $success = new Response();
        $success->setCode((int)$code);
        $success->setContent((string)$content);
        $success->setMessage((string)$message);

        exit($success->serializeToString());
    }

    public static function fail($code,$message,$content=''){
        $fail = new Response();
        $fail->setCode((int)$code);
        $fail->setMessage((string)$message);
        $fail->setContent($content);

        exit($fail->serializeToString());
    }


    public static function getResponse($data,$class='\apiauth\Response'){
        try{
            $response = new Response();
            $response->mergeFromString($data);

            $result = [];
            $result['code'] = $response->getCode();
            $result['content'] = $response->getContent();
            $result['message'] = $response->getMessage();

            return $result;
        }catch (\Exception $e){
            return false;
        }

    }

}