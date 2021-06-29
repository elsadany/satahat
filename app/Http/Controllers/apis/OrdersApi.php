<?php

namespace App\Http\Controllers\apis;

use Elsayednofal\BackendLanguages\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomepageResourse;
use Validator;
use App\Http\Resources\OrdersResource;
use App\Models\Address;
use App\Http\Resources\CartsResource;

class OrdersApi extends Controller {

    function index(request $request) {
        $rules = [
            'main_specialist_id' => 'required|exists:main_specialists,id',
            'secondary_specialist_id' => 'required|exists:secondary_specialists,id',
            'from_lat' => 'required',
            'from_lng' => 'required',
            'to_lat' => 'required',
            'to_lng' => 'required',
            'pay_method' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);

        $order = new \App\Models\Order();
        $order->user_id = $request->user()->id;

        $order->main_specialist_id = $request->main_specialist_id;
        $order->secondary_specialist_id = $request->secondary_specialist_id;
        $order->from_lat = $request->from_lat;
        $order->from_lng = $request->from_lng;
        $order->to_lat = $request->to_lat;
        $order->to_lng = $request->to_lng;
        $order->pay_method = $request->pay_method;
        $order->notes = $request->notes;

        $order->save();



        return response()->json(['status' => 200, 'message' => 'success', 'data' => $order->toArray()]);
    }

    function cancelOrder(Request $request) {
        $rules = [
            'order_id' => 'required|exists:orders,id',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $order = \App\Models\Order::where('user_id', $request->user()->id)->where('id', $request->order_id)->first();
        if (!is_object($order))
            return response()->json(['status' => 500, 'errors' => ['not found']]);
        if ($order->status_id >0)
            return response()->json(['status' => 500, 'errors' => ['it cant be cancelled']]);

        $order->status_id = 3;
        $order->reason=$request->reason;
        $order->save();
        return response()->json(['status' => 200, 'message' => 'success']);
    }

    function userOrders(Request $request) {
        $orders = \App\Models\Order::where('user_id', $request->user()->id)->orderBy('id', 'desc')->paginate(15);
        return response()->json(['status' => 200, 'data' => $orders->toArray()]);
    }

    public function notification($token, $title, $order, $status = 0) {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = $token;

        $notification = [
            'title' => $title,
            'sound' => true,
        ];

        $extraNotificationData = ["message" => $notification, "moredata" => $order, 'status' => $status, 'type' => 'order'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to' => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AAAArtZKFa8:APA91bHeYwZbe3sozr360iAV41RFMrCxqYzCsqANqSkDAx1aDKJj8ZSjSzhC6sCDBZKlUj3VMzHzbDKKSgIKUmyBtPMWRY-VX--KJNBavqQ0DvPY7gDZPgT_Prvd7-IReH-ILfI1TU-d',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    function newOrders() {
        $orders= \App\Models\Order::where('status_id',0)->OrderBy('id','desc')->get();
        return response()->json(['status'=>200,'data'=>$orders->toArray()]);
    }

    function DeliveryOrders(Request $request) {
        $orders = \App\Models\Order::where('delivery_id', auth()->user()->id);
        if ($request->status_id != '')
            $orders = $orders->where('status_id', $request->status_id);
        $orders = $orders->paginate(20);
        return response()->json(['status' => 200, 'data' => $orders->toArray()]);
    }

    function makeOffer(Request $request){
        $rules=['order_id'=>'required|exists:orders,id',
            'offer'=>'required',
            
            ];
           $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);

        $offer= \App\Models\Offer::where('delivery_id',$request->user()->id)->where('order_id',$request->order_id)->first();
        if(is_object($offer))
            return response ()->json (['status'=>500,'errors'=>['You Submitted error before']]);
        $offer=new \App\Models\Offer();
        $offer->delivery_id=$request->user()->id;
        $offer->offer=$request->offer;
        $offer->order_id=$request->order_id;
        $offer->save();
        return response()->json(['status'=>200,'message'=>'success']);
    }
    function chooseOffer(Request $request){
      $rules=['order_id'=>'required|exists:orders,id',
            'offer_id'=>'required|exists:offers,id',
            
            ];
           $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $order= \App\Models\Order::where('id',$request->order_id)->where('user_id',$request->user()->id)->first();
        if(!is_object($order))
            return response()->json (['status'=>500,'errors'=>['Order Not Found']]);
        if($order->status_id>0)
            return response()->json (['status'=>500,'errors'=>['Order has Already Offer']]);
   $offer= \App\Models\Offer::where('id',$request->offer_id)->where('order_id',$request->order_id)->first();
   if(!is_object($offer))
       return response ()->json(['status'=>500,'errors'=>['Offer Not Found']]);
   $order->offer=$offer->offer;
   $order->delivery_id=$offer->delivery_id;
   $order->status_id=1;
   $order->save();
   $offer->is_accept=1;
   $offer->save();
   return response()->json(['status'=>200,'message'=>'success']);
   
    }
}
