<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class MainSpecialistsController extends Controller
{
    function all(Request $request) {
        $main_specialists =new \App\Models\MainSpecialist;
     
        $main_specialists = $main_specialists->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $main_specialists->toArray()]);
    }

    function create(Request $request) {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $main_specialist = new \App\Models\MainSpecialist;
     
        $main_specialist->name_ar = $request->name_ar;
        $main_specialist->name_en = $request->name_en;
        
        $main_specialist->save();
        return response()->json(['status' => 200, 'message' => 'added']);
    }

    function show(Request $request) {
        $rules = [
            'main_specialist_id' => 'required|exists:main_specialists,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $main_specialist = \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->first();
            if (!is_object($main_specialist)){
                return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => ['main specialist Not Found']]);
            }else{
                return response()->json(['status' => 200, 'data' => $main_specialist->toArray()]);
            }
        }
    }

    function edit(Request $request) {
        $rules = [
            'main_specialist_id' => 'required|exists:main_specialists,id',
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
       
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $main_specialist = \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->first();
            if (!is_object($main_specialist)){
                return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => ['main specialist Not Found']]);
            }else{
                \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->update([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en
                ]);

                return response()->json(['status' => 200, 'message' => 'updated']);
            }
        }
    }

    function delete(Request $request) {
        $rules = [
            'main_specialist_id' => 'required|exists:main_specialists,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $main_specialist = \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->first();
            if (!is_object($main_specialist)){
                return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => ['main specialist Not Found']]);
            }else{
                $main_specialist = \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->delete();
                return response()->json(['status' => 200, 'message' => 'deleted']);
            }
        }
    }
}
