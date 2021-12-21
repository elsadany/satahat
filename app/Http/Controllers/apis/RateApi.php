<?php

namespace App\Http\Controllers\apis;

use Elsayednofal\BackendLanguages\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Wishlist;

class RateApi extends Controller {

    function add(Request $request) {
        $rules = [
            'rate' => 'required|min:1|max:5',
            'delivery_id' => 'required|exists:delivery,user_id',
            'order_id'=>'required|exists:orders,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $rate= \App\Models\Rate::where('user_id',$request->user()->id)->where('order_id',$request->order_id)->where('delivery_id',$request->delivery_id)->first();
        if(is_object($rate))
            return response ()->json (['status'=>422,'errors'=>['already Rated']],422);
        $rate = new \App\Models\Rate;
        $rate->delivery_id = $request->delivery_id;
        $rate->user_id = $request->user()->id;
        $rate->order_id=$request->order_id;
        $rate->comment = $request->comment;
        $rate->save();
        return response()->json(['status'=>201,'message'=>'success'], 201);
    }

}
