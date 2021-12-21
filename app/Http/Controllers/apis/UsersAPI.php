<?php

namespace App\Http\Controllers\apis;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OrdersResource;
use Illuminate\Support\Facades\Auth;

class UsersAPI extends Controller {

    function all(request $request) {
        $users = User::where('type', '!=', 4)->orderBy('id', 'desc');
         if ($request->type != '')
            $users = $users->where('type', $request->type);
      
        if ($request->active != '') {
           
            $users = $users->where('active', $request->active);
        }
        $users = $users->paginate(20);
        $arr = ['status' => 200, 'message' => '', 'data' => $users->toArray()];
        return response()->json($arr, 200);
    }

    function myacount(Request $request) {
        $user = $request->user();
        $arr = ['status' => 200, 'message' => '', 'data' => $user->toArray()];
        return response()->json($arr, 200);
    }

    function notifications(Request $request) {
        $user = $request->user();
        $arr = ['status' => 200, 'message' => '', 'data' => \App\Models\Notification::all()->toArray()];
        return response()->json($arr, 200);
    }

    function readNotifications(Request $request) {
        $rules = ['notification_id' => 'required|exists:notifications,id',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = $request->user();
        $notification = \App\Models\Notification::find($request->notification_id);
        $notification->is_read = 1;
        $notification->save();
        $arr = ['status' => 200, 'message' => '', 'message' => 'success'];
        return response()->json($arr, 200);
    }

    function active(Request $request) {
        $rules = ['user_id' => 'required|exists:users,id',
            'active' => 'required|integer'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);

        $user = User::find($request->user_id);
        $user->active = $request->active;
        $user->save();
        $arr = ['status' => 200, 'message' => 'success'];
        return response()->json($arr, 200);
    }

    function special(Request $request) {
        $rules = ['user_id' => 'required|exists:users,id',
            'special' => 'boolean'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);

        $user = \App\Models\Family::where('user_id', $request->user_id)->first();
        $user->special = $request->special;
        $user->save();
        $arr = ['status' => 200, 'message' => 'success'];
        return response()->json($arr, 200);
    }

    function updateProfile(Request $request) {
        $rules = [
            'name' => 'required',
         
            'phone' => 'required',
            //'job_id' => 'required|exists:jobs,id'
        ];

        if ($request->user()->phone != $request->phone)
            $rules['phone'] = 'required|unique:users,phone';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($request->password!='')
            $user->password= Hash::make($request->password);
        if ($request->hasFile('image'))
            $user->image = $this->uploadfile($request->image);
        if ($request->base_image != '')
            $user->image = $this->uploadbasfile($request->base_image);
        $user->save();
        $client = \App\Models\Client::find($user->id);
     
        $client->job_id = $request->job_id;
        $client->save();
        $arr = ['status' => 200, 'message' => 'success', 'data' => $user->toArray()];
        return response()->json($arr, 200);
    }

    function updateMaintanerProfile(Request $request) {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ];

        if ($request->user()->email != $request->email)
            $rules['email'] = 'required|email|unique:users,email';
        if ($request->user()->phone != $request->phone)
            $rules['phone'] = 'required|unique:users,phone';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->hasFile('image'))
            $user->image = $this->uploadfile($request->image);
        if ($request->base_image != '')
            $user->image = $this->uploadbasfile($request->base_image);
        $user->save();
        $maintaner = \App\Models\Maintaner::find($user->id);
        $maintaner->lat = $request->lat;
        $maintaner->lng = $request->lng;

        $maintaner->save();
        $arr = ['status' => 200, 'message' => 'success', 'data' => $user->toArray()];
        return response()->json($arr, 200);
    }

    function updateDeliveryProfile(Request $request) {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'main_specialist_id'=>'required|exists:main_specialists,id',
            'secondary_specialist_id'=>'required|exists:secondary_specialists,id',
        
        ];

        if ($request->user()->email != $request->email)
            $rules['email'] = 'required|email|unique:users,email';
        if ($request->user()->phone != $request->phone)
            $rules['phone'] = 'required|unique:users,phone';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->hasFile('image'))
            $user->image = $this->uploadfile($request->image);
        if ($request->base_image != '')
            $user->image = $this->uploadbasfile($request->base_image);
        if($request->password!='')
            $user->password= Hash::make($request->password);
        $user->save();
        $delivery = \App\Models\Delivery::find($user->id);
     
 
        $delivery->main_specialist_id = $request->main_specialist_id;
        $delivery->secondary_specialist_id = $request->secondary_specialist_id;
         if ($request->hasFile('id_image'))
            $delivery->id_image = $this->uploadfile($request->id_image);
        $delivery->save();
        $arr = ['status' => 200, 'message' => 'success', 'data' => $user->toArray()];
        return response()->json($arr, 200);
    }

    function updateDeliveryCar(Request $request){
        $rules = [
            'brand_id' => 'required|exists:brands,id',
            'model' => 'required',
            'car_number' => 'required',
            'insurance_number'=>'required',
        ];

        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);  
             $delivery = \App\Models\Delivery::find($request->user()->id);
             $delivery->brand_id=$request->brand_id;
             $delivery->model=$request->model;
             $delivery->car_number=$request->car_number;
             $delivery->insurance_number=$request->insurance_number;
              if ($request->hasFile('driving_licence'))
            $delivery->driving_licence = $this->uploadfile($request->driving_licence);
               if ($request->hasFile('authorize_image'))
            $delivery->authorize_image = $this->uploadfile($request->authorize_image);
             $delivery->save();
             $user= User::find($request->user()->id);
             return response()->json(['status'=>200,'data'=>$user->toArray()], 200);
    }
    function updateDeliverybank(Request $request){
        $rules = [
            'iban_id'=>'required',
            'bank_name'=>'required'
        ];

          if ($request->user()->delivery->iban_id != $request->iban_id)
            $rules['iban_id'] = 'required|unique:delivery,iban_id';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);  
             $delivery = \App\Models\Delivery::find($request->user()->id);
           $delivery->iban_id=$request->iban_id;
           $delivery->bank_name=$request->bank_name;
             $delivery->save();
             $user= User::find($request->user()->id);
             return response()->json(['status'=>200,'data'=>$user->toArray()], 200);
    }
    function updateDeliveryStatus(Request $request){
        $rules = [
            'status'=>'required|boolean',
         
        ];

     
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);  
             $delivery = \App\Models\Delivery::find($request->user()->id);
           $delivery->status=$request->status;
      
             $delivery->save();
             $user= User::find($request->user()->id);
             return response()->json(['status'=>200,'data'=>$user->toArray()], 200);
    }
    function updatePassword(Request $request) {

        $rules = [
            'old_password' => 'required|string',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $arr = ['status' => 422, 'message' => $validator->errors()->all()[0], 'errors' => $validator->errors()->all()];
            return response()->json($arr, 422);
        }

        $check_password = User::where([
            'id' => Auth::user()->id,
        ])->first();

        if(!password_verify($request->old_password, $check_password->password)){
            $arr = ['status' => 404, 'message' => 'wrong old password', 'errors' => $validator->errors()->all()];
            return response()->json($arr, 404);
        }

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();
        $arr = ['status' => 200, 'message' => 'password changed successfully', 'data' => ''];
        return response()->json($arr, 200);
    }

    public function resetPassword(Request $request){
        $rules = [
            'phone' => 'required|exists:users,phone',
            'confirmation_code' => 'required|string',
            'new_password' => 'required|string',
            'confirm_new_password' => 'required|same:new_password'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $arr = ['status' => 422, 'message' => $validator->errors()->all()[0], 'errors' => $validator->errors()->all()];
            return response()->json($arr, 422);
        }

        if($request->confirmation_code != '5555'){
            $arr = ['status' => 404, 'message' => 'invalid confirmation code', 'errors' => $validator->errors()->all()];
            return response()->json($arr, 404);
        }

        $check_phone = User::where([
            'phone' => $request->phone,
        ])->first();
        
        if(!is_object($check_phone)){
            $arr = ['status' => 404, 'message' => 'invalid phone number', 'errors' => $validator->errors()->all()];
            return response()->json($arr, 404);
        }

        User::where('id', $check_phone->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        $arr = ['status' => 200, 'message' => 'password updated successfully', 'errors' => $validator->errors()->all()];
        return response()->json($arr, 200);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        $arr = ['status' => 200, 'message' => 'Successfully logged out'];
        return response()->json($arr, 200);
    }

    function getAdreesses(Request $request) {
        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => Address::where('user_id', auth()->guard('api')->user()->id)->get()
        ], 200);
    }

    function addAdreess(Request $request) {
        $v = Validator::make($request->all(), [
                    'city_id' => 'required|exists:cities,id',
                    'address_name' => 'required',
                    'address_type' => 'required|numeric',
                    'address' => 'required',
                    'lat' => 'required',
                    'lng' => 'required',
        ]);

        if ($v->fails())
            return response()->json(['status' => 422, 'message' => trans('messages.invalide_data'), 'errors' => $v->errors()->all()], 422);

        $address = new Address;
        $address->city_id = $request->city_id;
        $address->address_name = $request->address_name;
        $address->address_type = $request->address_type;
        $address->address = $request->address;
        $address->lat = $request->lat;
        $address->lng = $request->lng;
        $address->user_id = auth()->guard('api')->user()->id;
        $address->save();

        return response()->json([
                    'status' => 201,
                    'message' => trans('messages.success'),
                    'data' => Address::where('user_id', auth()->guard('api')->user()->id)->get()
        ], 201);
    }

    function updateDeviceId(Request $request) {
        $v = Validator::make($request->all(), [
                    'device_id' => 'required',
        ]);

        if ($v->fails())
            return response()->json(['status' => 422, 'message' => trans('messages.invalide_data'), 'errors' => $v->errors()->all()], 422);
        $user = auth()->guard('api')->user();
        $user->device_id = $request->device_id;
        $user->save();
        return response()->json(['status' => 200, 'message' => 'success'], 200);
    }

    function updateAdrress(Request $request) {
        $v = Validator::make($request->all(), [
                    'address_id' => 'required|exists:addresses,id',
                    'city_id' => 'required|exists:cities,id',
                    'address_name' => 'required',
                    'address_type' => 'required|numeric',
                    'address' => 'required',
                    'lat' => 'required',
                    'lng' => 'required',
        ]);

        if ($v->fails())
            return response()->json(['status' => 422, 'message' => trans('messages.invalide_data'), 'errors' => $v->errors()->all()], 422);

        $address = Address::where('id', $request->address_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($address))
            return response()->json(['status' => 404, 'message' => trans('messages.invalide_data'), 'errors' => ['not found']], 404);

        $address->city_id = $request->city_id;
        $address->address_name = $request->address_name;
        $address->address_type = $request->address_type;
        $address->address = $request->address;
        $address->lat = $request->lat;
        $address->lng = $request->lng;
        $address->save();

        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => Address::where('user_id', auth()->guard('api')->user()->id)->get()
        ], 200);
    }

    function orders(Request $request) {
        $orders = \App\Models\Order::where('user_id', $request->user()->id)->orderBy('id', 'desc')->get();
        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => $orders->toArray()
        ], 200);
    }

    function showOrder(Request $request) {
        $order = \App\Models\Order::where('id', $request->order_id)->first();
        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => $order
        ], 200);
    }

    function cancelOrder(Request $request) {
        $order = \App\Models\Order::where('id', $request->order_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($order))
            return response()->json(['status' => 404, 'errors' => ['Order Not Found']], 404);
        if ($order->status_id > 0)
            return response()->json(['status' => 404, 'errors' => ['Order cant Not canceled now']], 404);
        \App\Models\Order::where('id', $request->order_id)->where('user_id', $request->user()->id)->delete();
        return response()->json([
                    'status' => 200,
                    'message' => 'success',
        ], 200);
    }

    function deleteAdrress(Request $request) {
        $v = Validator::make($request->all(), [
                    'address_id' => 'required|exists:addresses,id'
        ]);

        if ($v->fails())
            return response()->json(['status' => 422, 'message' => trans('messages.invalide_data'), 'errors' => $v->errors()->all()], 422);

        $address = Address::where('id', $request->address_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($address))
            return response()->json(['status' => 404, 'message' => trans('messages.invalide_data'), 'errors' => ['not found']], 404);

        $address->delete();

        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => Address::where('user_id', auth()->guard('api')->user()->id)->get()
        ], 200);
    }

    function familyStatics(Request $request) {
        $data['unread'] = \App\Models\Notification::count();
        $data['recieve'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', '>', 0)->where('status_id', '<', 5)->count();
        $data['in_mentain'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', '>', 4)->where('status_id', '<', 8)->count();
        $data['in_deliver'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', 9)->count();
        $data['all'] = \App\Models\Order::where('maintener_id', $request->user()->id)->count();
        $data['complete'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', 11)->count();
        $data['cancel'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', '>', 11)->count();

        return response()->json(['status' => 200, 'data' => $data], 200);
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

}
