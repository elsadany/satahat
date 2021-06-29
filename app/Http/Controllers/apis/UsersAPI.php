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

class UsersAPI extends Controller {

    function all(request $request) {
        $users = User::where('type', '!=', 4)->orderBy('id', 'desc');
        if ($request->type != '')
            $users = $users->where('type', $request->type);
        if ($request->special == 1) {
            $ids = \App\Models\Family::where('special', 1)->pluck('user_id')->toArray();
            $users = $users->whereIn('id', $ids);
        }
        $users = $users->paginate(20);
        $arr = ['status' => 200, 'message' => '', 'data' => $users->toArray()];
        return response()->json($arr);
    }

    function myacount(Request $request) {
        $user = $request->user();
        $arr = ['status' => 200, 'message' => '', 'data' => $user->toArray()];
        return response()->json($arr);
    }

    function notifications(Request $request) {
        $user = $request->user();
        $arr = ['status' => 200, 'message' => '', 'data' => \App\Models\Notification::all()->toArray()];
        return response()->json($arr);
    }

    function readNotifications(Request $request) {
        $rules = ['notification_id' => 'required|exists:notifications,id',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $user = $request->user();
        $notification = \App\Models\Notification::find($request->notification_id);
        $notification->is_read = 1;
        $notification->save();
        $arr = ['status' => 200, 'message' => '', 'message' => 'success'];
        return response()->json($arr);
    }

    function active(Request $request) {
        $rules = ['user_id' => 'required|exists:users,id',
            'active' => 'boolean'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);

        $user = User::find($request->user_id);
        $user->active = $request->active;
        $user->save();
        $arr = ['status' => 200, 'message' => 'success'];
        return response()->json($arr);
    }

    function special(Request $request) {
        $rules = ['user_id' => 'required|exists:users,id',
            'special' => 'boolean'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);

        $user = \App\Models\Family::where('user_id', $request->user_id)->first();
        $user->special = $request->special;
        $user->save();
        $arr = ['status' => 200, 'message' => 'success'];
        return response()->json($arr);
    }

    function updateProfile(Request $request) {
        $rules = [
            'name' => 'required',
          
            'email' => 'required',
            'phone' => 'required',
            'job_id' => 'required|exists:jobs,id'
        ];

        if ($request->user()->email != $request->email)
            $rules['email'] = 'required|email|unique:users,email';
        if ($request->user()->phone != $request->phone)
            $rules['phone'] = 'required|unique:users,phone';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
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
        return response()->json($arr);
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
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
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
        return response()->json($arr);
    }

    function updateDeliveryProfile(Request $request) {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
          'main_specialist_id'=>'required|exists:main_specialists,id',
          'secondary_specialist_id'=>'required|exists:secondary_specialists,id',
            'city_id' => 'required|exists:cities,id'
        ];

        if ($request->user()->email != $request->email)
            $rules['email'] = 'required|email|unique:users,email';
        if ($request->user()->phone != $request->phone)
            $rules['phone'] = 'required|unique:users,phone';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
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
     
        $delivery->city_id = $request->city_id;
        $delivery->main_specialist_id = $request->main_specialist_id;
        $delivery->secondary_specialist_id = $request->secondary_specialist_id;
         if ($request->hasFile('id_image'))
            $user->id_image = $this->uploadfile($request->id_image);
        
        $delivery->save();
        $arr = ['status' => 200, 'message' => 'success', 'data' => $user->toArray()];
        return response()->json($arr);
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
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);  
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
             return response()->json(['status'=>200,'data'=>$user->toArray()]);
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
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);  
             $delivery = \App\Models\Delivery::find($request->user()->id);
           $delivery->iban_id=$request->iban_id;
           $delivery->bank_name=$request->bank_name;
             $delivery->save();
             $user= User::find($request->user()->id);
             return response()->json(['status'=>200,'data'=>$user->toArray()]);
    }
            function updatePassword(Request $request) {

        $rules = [
            'password' => 'required|string',
            'confirm_password' => 'required|same:password'
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $arr = ['status' => 500, 'message' => $validator->errors()->all()[0], 'errors' => $validator->errors()->all()];

            return response()->json($arr);
        }

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();
        $arr = ['status' => 200, 'message' => 'password changed successfully', 'data' => ''];
        return response()->json($arr);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        $arr = ['status' => 200, 'message' => 'Successfully logged out'];
        return response()->json(
                        $arr);
    }

    function getAdreesses(Request $request) {
        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => Address::where('user_id', auth()->guard('api')->user()->id)->get()
        ]);
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
            return response()->json(['status' => 500, 'message' => trans('messages.invalide_data'), 'errors' => $v->errors()->all()]);

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
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => Address::where('user_id', auth()->guard('api')->user()->id)->get()
        ]);
    }

    function updateDeviceId(Request $request) {
        $v = Validator::make($request->all(), [
                    'device_id' => 'required',
        ]);

        if ($v->fails())
            return response()->json(['status' => 500, 'message' => trans('messages.invalide_data'), 'errors' => $v->errors()->all()]);
        $user = auth()->guard('api')->user();
        $user->device_id = $request->device_id;
        $user->save();
        return response()->json(['status' => 200, 'message' => 'success']);
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
            return response()->json(['status' => false, 'message' => trans('messages.invalide_data'), 'errors' => $v->errors()->all()]);

        $address = Address::where('id', $request->address_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($address))
            return response()->json(['status' => 500, 'message' => trans('messages.invalide_data'), 'errors' => ['not found']]);

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
        ]);
    }

    function orders(Request $request) {
        $orders = \App\Models\Order::where('user_id', $request->user()->id)->orderBy('id', 'desc')->get();
        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => $orders->toArray()
        ]);
    }

    function showOrder(Request $request) {
        $order = \App\Models\Order::where('id', $request->order_id)->first();
        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => $order
        ]);
    }

    function cancelOrder(Request $request) {
        $order = \App\Models\Order::where('id', $request->order_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($order))
            return response()->json(['status' => 500, 'errors' => ['Order Not Found']]);
        if ($order->status_id > 0)
            return response()->json(['status' => 500, 'errors' => ['Order cant Not canceled now']]);
        \App\Models\Order::where('id', $request->order_id)->where('user_id', $request->user()->id)->delete();
        return response()->json([
                    'status' => 200,
                    'message' => 'success',
        ]);
    }

    function deleteAdrress(Request $request) {
        $v = Validator::make($request->all(), [
                    'address_id' => 'required|exists:addresses,id'
        ]);

        if ($v->fails())
            return response()->json(['status' => 500, 'message' => trans('messages.invalide_data'), 'errors' => $v->errors()->all()]);

        $address = Address::where('id', $request->address_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($address))
            return response()->json(['status' => 500, 'message' => trans('messages.invalide_data'), 'errors' => ['not found']]);

        $address->delete();

        return response()->json([
                    'status' => 200,
                    'message' => trans('messages.success'),
                    'data' => Address::where('user_id', auth()->guard('api')->user()->id)->get()
        ]);
    }

    function familyStatics(Request $request) {
        $data['unread'] = \App\Models\Notification::count();
        $data['recieve'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', '>', 0)->where('status_id', '<', 5)->count();
        $data['in_mentain'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', '>', 4)->where('status_id', '<', 8)->count();
        $data['in_deliver'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', 9)->count();
        $data['all'] = \App\Models\Order::where('maintener_id', $request->user()->id)->count();
        $data['complete'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', 11)->count();
        $data['cancel'] = \App\Models\Order::where('maintener_id', $request->user()->id)->where('status_id', '>', 11)->count();

        return response()->json(['status' => 200, 'data' => $data]);
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
        return $path . '/' . $filename;
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
