<?php

namespace App\Http\Controllers\APi;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'phone_number' => 'string|max:20',
            'email' => 'string|email',
            'password' => 'required|string|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);



        if(($request->email == "" and $request->phone_number == "")){
            $apis = new ApiHelper();
            $apis->createApiResponse(true, 200, "email_phone_code", "");
            return;
        }
        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();

            $apis = new ApiHelper();
            $apis->createApiResponse(true, 200, "validation error", $errors);
            return;

        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'status' => 0,
                'password' => bcrypt($request->password),
                'type' => 1,
            ]);

            $credentials1 = (['email' => $request->email,
                'password' => $request->password]);
            $credentials2 = (['phone_number' => $request->phone_number,
                'password' => $request->password]);

            if (!(Auth::attempt($credentials1) or Auth::attempt($credentials2))) {
                $apis = new ApiHelper();
                $apis->createApiResponse(true, 200, "بيانات الدخول غير صحيحة", "");
                return;
            }
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            return response()->json([
                'access_token' => 'Bearer '.$tokenResult->accessToken,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        }


        $apis = new ApiHelper();
        $apis->createApiResponse(true, 200, "validation error", "");
        return;


    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
       $rules = [
           'password' => 'required|string',
           'remember_me' => 'boolean'
       ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
            $apis = new ApiHelper();
            $apis->createApiResponse(true, 200, "validation error", $errors);
            return;

        }
       else{
           $credentials1 = (['email' => $request->email,
               'password' => $request->password]);
           $credentials2 = (['phone_number' => $request->phone_number,
               'password' => $request->password]);

           if (!(Auth::attempt($credentials1) or Auth::attempt($credentials2))) {
               $apis = new ApiHelper();
               $apis->createApiResponse(true, 200, "بيانات الدخول غير صحيحة", "");
               return;
           }
           $user = $request->user();
           $tokenResult = $user->createToken('Personal Access Token');
           $token = $tokenResult->token;
           if ($request->remember_me)
               $token->expires_at = Carbon::now()->addWeeks(1);
           $token->save();
           return response()->json([
               'access_token' => 'Bearer '.$tokenResult->accessToken,
               'expires_at' => Carbon::parse(
                   $tokenResult->token->expires_at
               )->toDateTimeString()
           ]);
       }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
