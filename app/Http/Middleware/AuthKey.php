<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token =  $request->header('goods_key');

//        if($token != "5f58fd92390de"){
//            $data['success'] = "false";
//            $data['code'] = 403;
//            $data['message'] = "غير مصرح بالدخول";
//            $data['content'] = "";
//
//            return response()->json($data,403);
//
//        }
        return $next($request);
    }
}
