<?php


namespace App\Functions;


class ApiHelper
{
    public static function createApiResponse($is_error,$code,$message,$content){
        $data['success'] = $is_error ? "false" : "true";
//        $data['code'] = $code;
        $data['message'] = $message;
        $data['content'] = $content;

        echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);


    }
}
