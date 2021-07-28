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
            'delivery_id' => 'required|exists:delivery,user_id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $rate = new \App\Models\Rate;
        $rate->delivery_id = $request->delivery_id;
        $rate->user_id = $request->user()->id;
        $rate->comment = $request->comment;
        $rate->save();
        return response()->json(['status'=>200,'message'=>'success']);
    }

}
