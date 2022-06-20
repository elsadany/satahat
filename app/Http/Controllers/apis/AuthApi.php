<?php

namespace App\Http\Controllers\apis;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Cart;
use App\Models\PhoneCode;

class AuthApi extends Controller {
    function sendSms(Request $request) {
        $rules = [
            'phone' => 'required|numeric',
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $arr = ['status' => 500, 'errors' => $validator->errors()->all()];

            return response()->json($arr);
        }
        $code = $this->generatemobie(4);
        $phone = new \App\Models\PhoneCode();
        $phone->code = $code;
        $phone->phone = $request->phone;
        $phone->save();
      
        // if($response!=false||$response->ErrorCode!='000')
        //     return response ()->json(['status'=>200,'errors'=>['there are error in sms provider']]);
        $user = User::where('phone', $request->phone)->first();
        if (is_object($user))
            $arr = ['status' => 200, 'message' => 'exists'];
        else
            $arr = ['status' => 200, 'message' => 'success'];


        return response()->json($arr);
    }

    function confirm(Request $request) {
        $rules = [
            'phone' => 'required|exists:phone_codes,phone',
            'confirm_code' => 'required|exists:phone_codes,code'
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $arr = ['status' => 500, 'errors' => $validator->errors()->all()];

            return response()->json($arr);
        }

        $phone = \App\Models\PhoneCode::where('phone', $request->phone)->where('code', $request->confirm_code)->first();
        if (!is_object($phone)) {


            $arr = ['status' => 500, 'errors' => ['error']];

            return response()->json($arr);
        }
        \App\Models\PhoneCode::where('phone', $request->phone)->delete();
        return response()->json(['status' => 200, 'message' => 'success']);
    }
    



    function register(Request $request) {
        $validator = Validator::make($request->all(), [
                   'email' => 'required|string|email|unique:users,email',
                    'phone' => 'required|string|unique:users,phone',
                    'name' => 'required|string',
                    'password' => 'required|string|min:6',
                    'confirm_password' => 'required|string|same:password',
        ],['email.required'=>trans('auth.email_required')
            ,'email.unique'=>trans('auth.email_unique')
            ,'phone.required'=>trans('auth.phone_required'),
            'phone.unique'=>trans('auth.phone_unique'),
            'password.required'=>trans('auth.password_required'),
            'confirm_password.required'=>trans('auth.confirm_password_required'),
             'confirm_password.same'=>trans('auth.confirm_password_same')
            ]);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' =>$validator->errors()->all()[0], 'errors' => $validator->errors()->all()]);
        $user = new User();
       $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
             if($request->hasFile('image'))
            $user->image= $this->uploadfile ($request->file('image'));
        $user->password = Hash::make($request->password);
        $user->active=0;
        $user->save();
       $phonecode=new PhoneCode();
       $phonecode->code=$this->generatemobie();
       $phonecode->email=$request->email;
       $phonecode->user_id=$user->id;
       $phonecode->save();
       $this->sendActivationEmail($phonecode->email,$phonecode->code);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $user= User::find($user->id);
        $response['status'] = true;
        $response['message'] = trans('auth.success');
        $response['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => $user->toArray()
        ];
        return response()->json($response, 201);
    }
    function active(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|exists:phone_codes,code',
          
 ]);
 if ($validator->fails())
     return response()->json(['status' => false, 'message' => $validator->errors()->all()[0], 'errors' => $validator->errors()->all()]);

        $phonecode=PhoneCode::where('user_id',$request->user()->id)->where('code',$request->code)->first();
        if(!is_object($phonecode))
        return response()->json(['status'=>false,'message'=>'Active code wrong']);
        $user=User::find($request->user()->id);
        $user->active=1;
        $user->save();
        PhoneCode::where('user_id',$request->user()->id)->delete();
        return response()->json(['status'=>true,'message'=>'Email Actived Successfully']);
        



    }

    function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'phone' => 'required|string|exists:users,phone',
                    'password' => 'required|string',
                        //'remember_me' => 'boolean'
        ],['email.required'=>trans('auth.email_required')
            ,'email.exists'=>trans('auth.email_exists')
           ,
            'password.required'=>trans('auth.password_required'),
      
            ]);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = User::where('email', $request->email)->first();

        if (!is_object($user) || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 404, 'message' =>trans('auth.incorrect_email'), 'errors' => [trans('auth.incorrect_email')]], 404);
        }


        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $response['status'] = true;
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

    function loginSocial(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email',
                    'name' => 'required|string',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = User::where('email', $request->email)->first();

        if (!is_object($user)) {
            $data = $request->only('email','name');

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
    function ForgetPassword(Request $request){
        $rules = [
            'email' => 'required|exists:users,email',
          
        ];
        $validator = \Validator::make($request->all(), $rules
        ,['email.required'=>'البريد ألالكترونى ألزامى'
            ,'email.exists'=>'هذا البريد غير موجود '
             ]);

        if ($validator->fails()) {

            $arr = ['status' => false, 'errors' => $validator->errors()->all()];

            return response()->json($arr);
        } 
        $user=User::where('email',$request->email)->first();
        $phonecode=new PhoneCode();
       $phonecode->code=$this->generatemobie();
       $phonecode->email=$request->email;
       $phonecode->user_id=$user->id;
       $phonecode->save();
       $this->sendResetEmail($phonecode->email,$phonecode->code);
       $arr = ['status' => true, 'message' => 'Your Reset Code Sent successfully.'];
       return response()->json($arr);
    }
 function resetPassword(Request $request) {
        $rules = [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $arr = ['status' => 422, 'errors' => $validator->errors()->all()];

            return response()->json($arr,422);
        }

        $user = User::where('phone',$request->phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        \App\Models\PhoneCode::where('phone', $request->phone)->delete();
        $arr = ['status' => true, 'message' => 'Your password updated successfully, try login now'];
        return response()->json($arr);

    }
    function sendActivationEmail($email,$code){
        $text="<h2>Dear </h2>
        <br>
        <p>Your Activation Code is</p>
        <p>$code</p>
        <br>";
      

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'From: info@sha7n.com ' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
    
            @mail($email, 'Activation Code', $text,$headers);
        
    }
    function sendResetEmail($email,$code){
        $text="<h2>Dear </h2>
        <br>
        <p>Your Reset Code is</p>
        <p>$code</p>
        <br>";
      

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'From: info@sha7n.com ' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
    
            @mail($email, 'Reset Code', $text,$headers);
        
    }
}
