<?php

namespace App\Http\Controllers\apis;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Cart;

class AuthApi extends Controller {

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
        $phone->code = $this->generatemobie(4);
        $phone->phone = $request->phone;
        $phone->save();
        $user = User::where('phone', $request->phone)->first();
        if (!is_object($user))
            return response()->json(['status' => 404, 'message' => 'phone not found'], 404);
        else
            return response()->json(['status' => 201, 'message' => 'success'], 201);
    }

    function confirm(Request $request) {
        $rules = [
            'phone' => 'required|exists:phone_codes,phone',
            'confirm_code' => 'required|exists:phone_codes,code'
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $arr = ['status' => 422, 'errors' => $validator->errors()->all()];
            return response()->json($arr, 422);
        }

        $phone = \App\Models\PhoneCode::where('phone', $request->phone)->where('code', $request->confirm_code)->first();
        if (!is_object($phone)) {
            $arr = ['status' => 404, 'errors' => ['phone not found'], 404];
            return response()->json($arr, 404);
        }
        \App\Models\PhoneCode::where('phone', $request->phone)->delete();

        $response['status'] = 200;
        $response['message'] = 'success';

        return response()->json($response, 200);
    }

    function register(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email|unique:users,email',
                    'phone' => 'required|string|unique:users,phone',
                    'name' => 'required|string',
                    'job_id' => 'required|exists:jobs,id',
                    'password' => 'required|string',
                    'confirm_password' => 'required|string|same:password',
                        //'remember_me' => 'boolean'
        ]);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->type = 1;
        $user->save();
        $client = new \App\Models\Client;
        $client->user_id = $user->id;
        $client->job_id = $request->job_id;
        $client->save();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $user= User::find($user->id);
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
            return response()->json(['status' => 404, 'message' => 'incorrect email or password', 'errors' => ['incorrect email or password']]);
        }


        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $response['status'] = 200;
        $response['message'] = 'login successfully';
        $response['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'remember' => $request->remember_me ? true : false,
            'user' => $user->toArray()
        ];
        return response()->json($response, 200);
    }

    function delivaryRegister(Request $request) {
        $rules = [
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'confirm_password' => 'required|string|same:password',
            'phone' => 'required|numeric|unique:users,phone',
            'name' => 'required',
            'main_specialist_id'=>'required|exists:main_specialists,id',
            'secondary_specialist_id'=>'required|exists:secondary_specialists,id',
            'brand_id'=>'required|exists:brands,id',
            'city_id'=>'required|exists:cities,id',
            'id_image'=>'required|image',
            'driving_licence'=>'required|image',
            'image'=>'required|image',
            'model'=>'required',
            'car_number'=>'required',
            'insurance_number'=>'required',
            'iban_id'=>'required|unique:delivery,iban_id',
            'bank_name'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = new User();
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->image= $this->uploadfile($request->image);
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
        $delivery->iban_id = $request->iban_id;
        $delivery->bank_name = $request->bank_name;
        $delivery->car_number = $request->car_number;
        $delivery->insurance_number = $request->insurance_number;
        $delivery->id_image= $this->uploadfile($request->id_image);
        $delivery->driving_licence= $this->uploadfile($request->driving_licence);
        if($request->hasFile('authorize_image'))
            $delivery->authorize_image= $this->uploadfile ($request->authorize_image);
        $delivery->save();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
//        if ($request->remember_me)
        $token->expires_at = Carbon::now()->addWeeks(2);
        $token->save();
        $user= User::find($user->id);

        $arr['status'] = 201;
        $arr['message'] = 'delivery user registered successfully';
        $arr['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user->toArray()
        ];
        return response()->json($arr, 201);
    }

    function loginSocial(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email',
                    'name' => 'required|string',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = User::where('email', $request->email)->first();

        if (!is_object($user)) {
            $data = $request->all();

            $user = User::create($data);
        } else {

            $user->phone = $request->phone;
            $user->name = $request->name;
            $user->save();
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();
        $arr['status'] = true;
        $arr['message'] = 'success';
        $arr['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'userdata' => $user->toArray()
        ];
        return response()->json($arr, 200);
    }

    private function uploadfile($file) {
        $path = 'uploads/users';
        if (!file_exists($path)) {
            mkdir($path, 0775);
        }
        $datepath = date('m-Y', strtotime(\Carbon\Carbon::now()));
        if (!file_exists($path . '/' . $datepath)) {
            mkdir($path . '/' . $datepath, 0775);
        }
        $newdir = $path . '/' . $datepath;
        $exten = $file->getClientOriginalExtension();
        $filename = $this->generateRandom($length = 15);
        $filename = $filename . '.' . $exten;
        $file->move($newdir, $filename);
        return $newdir . '/' . $filename;
    }

    private function generateRandom($length = 11) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = time();
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    private function uploadbasfile($file) {
        $path = 'uploads/users';
        if (!file_exists($path)) {
            mkdir($path, 0775);
        }
        $datepath = date('m-Y', strtotime(\Carbon\Carbon::now()));
        if (!file_exists($path . '/' . $datepath)) {
            mkdir($path . '/' . $datepath, 0775);
        }
        $newdir = $path . '/' . $datepath;
        $exten = 'png';
        $filename = $this->generateRandom($length = 15);
        $filename = $filename . '.' . $exten;
        $filedate = base64_decode($file);

        file_put_contents($newdir . '/' . $filename, $filedate);

        return $newdir . '/' . $filename;
    }

    function generatemobie($length = 4) {
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
