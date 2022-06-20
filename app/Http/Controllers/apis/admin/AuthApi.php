<?php

namespace App\Http\Controllers\apis\admin;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Cart;

class AuthApi extends Controller {


    function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                        //'remember_me' => 'boolean'
        ]);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $user = Admin::where('email', $request->email)->first();

        if (!is_object($user) || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'incorrect email or password', 'errors' => ['incorrect email or password']]);
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $response['status'] = true;
        $response['message'] = 'login success';
        $response['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'remember' => $request->remember_me ? true : false,
            'user' => $user->toArray()
        ];
        return response()->json($response, 200);
    }
      function myacount(Request $request) {
        $user = $request->user();
        $arr = ['status' => true, 'message' => '', 'data' => $user->toArray()];
        return response()->json($arr, 200);
    }

}
