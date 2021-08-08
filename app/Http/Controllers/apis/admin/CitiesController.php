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
        return response()->json(['status' => 200, 'data' => $cities->toArray()], 200);
    }

    function create(Request $request) {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $city = new \App\Models\City;
     
        $city->name_ar = $request->name_ar;
        $city->name_en = $request->name_en;
        
        $city->save();
        return response()->json(['status' => 201, 'message' => 'added'], 201);
    }

    function show(Request $request) {
        $rules = [
            'city_id' => 'required|exists:cities,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $city = \App\Models\City::where('id', $request->city_id)->first();
            if (!is_object($city)){
                return response()->json(['status' => 404, 'message' => 'Invalid Data', 'errors' => ['city Not Found']], 404);
            }else{
                return response()->json(['status' => 200, 'data' => $city->toArray()], 200);
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
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $city = \App\Models\City::where('id', $request->city_id)->first();
            if (!is_object($city)){
                return response()->json(['status' => 404, 'message' => 'city not found', 'errors' => ['city Not Found']]);
            }else{
                \App\Models\City::where('id', $request->city_id)->update([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en
                ]);

                return response()->json(['status' => 200, 'message' => 'updated'], 200);
            }
        }
    }

    function delete(Request $request) {
        $rules = [
            'city_id' => 'required|exists:cities,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $city = \App\Models\City::where('id', $request->city_id)->first();
            if (!is_object($city)){
                return response()->json(['status' => 404, 'message' => 'city not found', 'errors' => ['city Not Found']], 404);
            }else{
                $city = \App\Models\City::where('id', $request->city_id)->delete();
                return response()->json(['status' => 200, 'message' => 'deleted'], 200);
            }
        }
    }
}
