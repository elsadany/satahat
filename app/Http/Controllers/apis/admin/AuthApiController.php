<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthApiController extends Controller
{
    // admin login
    function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                    //'remember_me' => 'boolean'
        ]);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = User::where('email', $request->email)->where('type', 4)->first();

        if (!is_object($user) || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 404, 'message' => 'incorrect email or password', 'errors' => ['incorrect email or password']], 404);
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $response['status'] = 200;
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
}
