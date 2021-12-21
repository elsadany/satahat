<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\MainSpecialist;
use App\Models\SecondarySpecialist;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;


class AuthApiController extends Controller
{
    function send(Request $request) {
        $rules = [
            'phone' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $arr = ['status' => 422, 'errors' => $validator->errors()->all()];
            return response()->json($arr, 422);
        }
//        dd($this->sendSms('123', '201114591647'));
        $phone = new \App\Models\PhoneCode();
        $phone->code = $this->generateMobile(4);
        $phone->phone = $request->phone;
        $phone->save();
        $user = User::where('phone', $request->phone)->first();
        // if (is_object($user))
        //     return response()->json(['status' => 404, 'message' => 'phone is already used'], 404);
        // else
            // return response()->json(['status' => 201, 'message' => 'success'], 201);
        return response()->json([
            'status' => 201, 
            'message' => 'success', 
            'verification_code' =>  $phone->code
        ], 201);
    }

    function register(Request $request) {
        $validator = Validator::make($request->all(), [
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,phone',
                    'name' => 'required|string',
                    'password' => 'required|string|min:6',
                    'confirm_password' => 'required|string|same:password'
                    //'remember_me' => 'boolean'
        ]);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = new User();
        $user->email = \Carbon\Carbon::now();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->type = 1;
        $user->save();
        // $client = new \App\Models\Client;
        // $client->user_id = $user->id;
        // $client->job_id = $request->job_id;
        // $client->save();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $response['status'] = 201;
        $response['message'] = 'client user registered successfully';
        $response['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => $user->toArray()
        ];
        return response()->json($response, 201);
    }

    function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'phone' => 'required|string|exists:users,phone',
                    'password' => 'required|string',
                    //'remember_me' => 'boolean'
        ]);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = User::where('phone', $request->phone)->first();

        if (!is_object($user) || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 404, 'message' => 'incorrect email or password', 'errors' => ['incorrect email or password']], 404);
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $response['status'] = 200;
        $response['message'] = 'user logged in successfully';
        $response['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'remember' => $request->remember_me ? true : false,
            'user' => $user->toArray()
        ];
        return response()->json($response, 200);
    }

    function confirm(Request $request) {
        $rules = [
            'phone' => 'required|exists:phone_codes,phone',
            'confirm_code' => 'required|exists:phone_codes,code'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $arr = ['status' => 422, 'errors' => $validator->errors()->all()];
            return response()->json($arr, 422);
        }

        $phone = \App\Models\PhoneCode::where('phone', $request->phone)->where('code', $request->confirm_code)->first();
        if (!is_object($phone)) {
            $arr = ['status' => 404, 'errors' => ['error']];
            return response()->json($arr, 404);
        }
        \App\Models\PhoneCode::where('phone', $request->phone)->delete();

        $response['status'] = 200;
        $response['message'] = 'success';

        return response()->json($response, 200);
    }

    function deliveryRegister(Request $request) {
        $rules = [
            'email' => 'required|string|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/|min:6|unique:users,email',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone',
            'name' => 'required',
            'main_specialist_id'=>'required|exists:main_specialists,id',
            'secondary_specialist_id'=>'required|exists:secondary_specialists,id',
            'brand_id'=>'required|exists:brands,id',
            'city_id'=>'required|exists:cities,id',
            'id_image'=>'required|image',
            'image'=>'required|image',
            'driving_license'=>'required|image',
            'model'=>'required',
            'car_number'=>'required',
            'insurance_number'=>'required',
            'iban'=>'required|unique:delivery,iban',
            'bank_name'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = new User();
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->image= uploadfile($request->image, 'users');
        $user->type = 2;
        $user->password = Hash::make($request->password);
        $user->save();
        $delivery = new \App\Models\Delivery();
        $delivery->user_id=$user->id;
        $delivery->main_specialist_id = $request->main_specialist_id;
        $delivery->secondary_specialist_id = $request->secondary_specialist_id;
        $delivery->brand_id = $request->brand_id;
        $delivery->city_id = $request->city_id;
        $delivery->model = $request->model;
        $delivery->iban = $request->iban;
        $delivery->bank_name = $request->bank_name;
        $delivery->car_number = $request->car_number;
        $delivery->insurance_number = $request->insurance_number;
        $delivery->id_image= uploadfile($request->id_image, 'users');
        $delivery->driving_license= uploadfile($request->driving_license, 'users');
        if($request->hasFile('authorize_image'))
            $delivery->authorize_image= uploadfile ($request->authorize_image, 'users');
        $delivery->save();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
//        if ($request->remember_me)
        $token->expires_at = Carbon::now()->addWeeks(2);
        $token->save();

        $brand = Brand::where('id', $request->brand_id)->first();
        $main_specialist = MainSpecialist::where('id', $request->main_specialist_id)->first();
        $secondary_specialist = SecondarySpecialist::where('id', $request->secondary_specialist_id)->first();

        $arr['status'] = 201;
        $arr['message'] = 'success';
        $arr['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user->toArray(),
            'delivery' => $delivery->toArray(),
            'brand' => $brand->toArray(),
            'main_specialist' => $main_specialist->toArray(),
            'secondary_specialist' => $secondary_specialist->toArray(),
        ];
        return response()->json($arr, 201);
    }

    function generateMobile($length = 4) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return '5555';
        return $randomString;
    }
}
