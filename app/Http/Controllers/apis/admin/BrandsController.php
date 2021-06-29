<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BrandsController extends Controller
{
    function all(Request $request) {
        $brands =new \App\Models\Brand;
     
        $brands = $brands->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $brands->toArray()]);
    }

    function create(Request $request) {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $brand = new \App\Models\Brand();
     
        $brand->name_ar = $request->name_ar;
        $brand->name_en = $request->name_en;
        
        $brand->save();
        return response()->json(['status' => 200, 'message' => 'added']);
    }

    function show(Request $request) {
        $rules = [
            'brand_id' => 'required|exists:brands,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        }else{
            $brand = \App\Models\Brand::where('id', $request->brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => ['brand Not Found']]);
            }else{
                return response()->json(['status' => 200, 'data' => $brand->toArray()]);
            }
        }
    }

    function edit(Request $request) {
        $rules = [
            'brand_id' => 'required|exists:brands,id',
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
       
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        }else{
            $brand = \App\Models\Brand::where('id', $request->brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => ['brand Not Found']]);
            }else{
                \App\Models\Brand::where('id', $request->brand_id)->update([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en
                ]);

                return response()->json(['status' => 200, 'message' => 'updated']);
            }
        }
    }

    function delete(Request $request) {
        $rules = [
            'brand_id' => 'required|exists:brands,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        }else{
            $brand = \App\Models\Brand::where('id', $request->brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => ['brand Not Found']]);
            }else{
                $brand = \App\Models\Brand::where('id', $request->brand_id)->delete();
                return response()->json(['status' => 200, 'message' => 'deleted']);
            }
        }
    }
}
