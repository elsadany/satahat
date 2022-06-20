<?php

namespace App\Http\Controllers\apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Card;
use Validator;


class CardsController extends Controller {

    function index(request $request) {
       $cards=Card::where('user_id',$request->user()->id)->latest('id')->get();


        return response()->json(['status' => true, 'message' => 'success', 'data' => $cards->toArray()], 200);
    }

 function add(Request $request){
     $rules=[
         'card_brand_id'=>'required|exists:card_brands,id',
         'full_name'=>'required',
         'card_number'=>'required|min:16|max:16',
         'expiry_date'=>'required|date_format:Y-m',

     ];
     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()){
         return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
     }
     $card=new Card();
     $card->user_id=$request->user()->id;
     $card->full_name=$request->full_name;
     $card->card_brand_id=$request->card_brand_id;
     $card->expiry_date=date('Y-m-d',strtotime($request->expiry_date));
     $card->save();
     return response()->json(['status'=>true,'message'=>'Card Added']);

 }
 function edit(Request $request){
     $rules=[
         'card_brand_id'=>'required|exists:card_brands,id',
         'full_name'=>'required',
         'card_number'=>'required|min:16|max:16',
         'expiry_date'=>'required|date_format:Y-m',
         'card_id'=>'required|exists:cards,id'

     ];
     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()){
         return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }
        $card=Card::where('id',$request->card_id)->where('user_id',$request->user()->id)->first();
        if(!is_object($card))
        return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Card not Found']]);
     $card->user_id=$request->user()->id;
     $card->full_name=$request->full_name;
     $card->card_brand_id=$request->card_brand_id;
     $card->expiry_date=date('Y-m-d',strtotime($request->expiry_date));
     $card->save();
     return response()->json(['status'=>true,'message'=>'Card edited']);

 }
 function show(Request $request){
     $rules=[
         'card_id'=>'required|exists:cards,id',
        

     ];
     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()){
         return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }
        $card=Card::where('id',$request->card_id)->where('user_id',$request->user()->id)->first();
        if(!is_object($card))
        return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Card not Found']]);
    
     return response()->json(['status'=>true,'message'=>'Card edited','data'=>$card->toArray()]);

 }
 function active(Request $request){
     $rules=[
         'card_id'=>'required|exists:cards,id',
        

     ];
     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()){
         return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }
        $card=Card::where('id',$request->card_id)->where('user_id',$request->user()->id)->first();
        if(!is_object($card))
        return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Card not Found']]);
    if($card->active==1)
    $card->active=0;
    else
    $card->active=1;
    $card->save();
     return response()->json(['status'=>true,'message'=>'Card edited','data'=>$card->toArray()]);

 }
 function delete(Request $request) {
    $rules = [
         'card_id'=>'required|exists:cards,id',
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()){
        return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
    }else{
        $card=Card::where('id',$request->card_id)->where('user_id',$request->user()->id)->first();
        if (!is_object($card)){
            return response()->json(['status' => false, 'message' => 'Card not found', 'errors' => ['Card Not Found']]);
        }else{
            $brand = Card::where('id',$request->card_id)->where('user_id',$request->user()->id)->delete();
            return response()->json(['status' => true, 'message' => 'deleted']);
        }
    }
}

}
