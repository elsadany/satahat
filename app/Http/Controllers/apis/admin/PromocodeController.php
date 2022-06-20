<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Validator;

class PromocodeController extends Controller
{
    function index(Request $request) {
        $promocodes =new \App\Models\PromoCode();
     
        $promocodes = $promocodes->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $promocodes->toArray()], 200);
    }

    function add(Request $request) {
        $rules = [
            'code' => 'required|unique:promo_codes,code',
            'discount_precentage' => 'required|numeric|max:99',
            'expire_at'=>'required|after:tomorrow|date'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $promocode = new \App\Models\PromoCode();
        $promocode->code = $request->code;

        $promocode->discount_precentage = $request->discount_precentage;
        $promocode->expire_at = $request->expire_at;
        
        $promocode->save();
        return response()->json(['status' => true, 'message' => 'added'] );
    }

    function display(Request $request) {
        $rules = [
            'promo_code_id' => 'required|exists:promo_codes,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $promocode = \App\Models\PromoCode::where('id', $request->promo_code_id)->first();
            if (!is_object($promocode)){
                return response()->json(['status' => false, 'message' => 'brand not found', 'errors' => ['brand Not Found']]);
            }else{
                return response()->json(['status' => true, 'data' => $promocode->toArray()]);
            }
        }
    }

    function edit(Request $request) {
        
        $rules = [
            'promo_code_id' => 'required|exists:promo_codes,id',
            'discount_precentage' => 'required|numeric|max:99',
            'expire_at'=>'required|after:tomorrow|date',
            'code' => 'required',

        ];
      
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }
        $promocode=PromoCode::find($request->promo_code_id);
        $rules['code']='required|unique:promo_codes,code,'.$promocode->id;
            $promocode = \App\Models\PromoCode::where('id', $request->promo_code_id)->first();
          
              
                \App\Models\PromoCode::where('id', $request->promo_code_id)->update([
                    'code' => $request->code,
                    'discount_precentage' => $request->discount_precentage,
                    'expire_at'=>$request->expire_at
                ]);

                return response()->json(['status' => 200, 'message' => 'updated'], 200);
            
        
    }

    function delete(Request $request) {
        $rules = [
            'promo_code_id' => 'required|exists:promo_codes,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $promocode = \App\Models\PromoCode::where('id', $request->promo_code_id)->first();
            if (!is_object($promocode)){
                return response()->json(['status' => false, 'message' => 'brand not found', 'errors' => ['brand Not Found']]);
            }else{
                $promocode = \App\Models\PromoCode::where('id', $request->promo_code_id)->delete();
                return response()->json(['status' => true, 'message' => 'deleted']);
            }
        }
    }
       private function uploadfile($file) {
        $path = 'uploads/banners';
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
}
