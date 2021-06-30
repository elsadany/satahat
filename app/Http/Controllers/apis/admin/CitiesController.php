<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CitiesController extends Controller
{
    function all(Request $request) {
        $cities =new \App\Models\City;
     
        $cities = $cities->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $cities->toArray()]);
    }

    function create(Request $request) {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $city = new \App\Models\City;
     
        $city->name_ar = $request->name_ar;
        $city->name_en = $request->name_en;
        
        $city->save();
        return response()->json(['status' => 200, 'message' => 'added']);
    }

    function show(Request $request) {
        $rules = [
            'city_id' => 'required|exists:cities,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $city = \App\Models\City::where('id', $request->city_id)->first();
            if (!is_object($city)){
                return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => ['city Not Found']]);
            }else{
                return response()->json(['status' => 200, 'data' => $city->toArray()]);
            }
        }
    }

    function edit(Request $request) {
        $rules = [
            'city_id' => 'required|exists:cities,id',
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
       
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $city = \App\Models\City::where('id', $request->city_id)->first();
            if (!is_object($city)){
                return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => ['city Not Found']]);
            }else{
                \App\Models\City::where('id', $request->city_id)->update([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en
                ]);

                return response()->json(['status' => 200, 'message' => 'updated']);
            }
        }
    }

    function delete(Request $request) {
        $rules = [
            'city_id' => 'required|exists:cities,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $city = \App\Models\City::where('id', $request->city_id)->first();
            if (!is_object($city)){
                return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => ['city Not Found']]);
            }else{
                $city = \App\Models\City::where('id', $request->city_id)->delete();
                return response()->json(['status' => 200, 'message' => 'deleted']);
            }
        }
    }
}
