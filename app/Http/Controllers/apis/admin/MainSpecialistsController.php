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
        return response()->json(['status' => 200, 'data' => $main_specialists->toArray()], 200);
    }

    function create(Request $request) {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $main_specialist = new \App\Models\MainSpecialist;
     
        $main_specialist->name_ar = $request->name_ar;
        $main_specialist->name_en = $request->name_en;
        
        $main_specialist->save();
        return response()->json(['status' => 201, 'message' => 'added'], 201);
    }

    function show(Request $request) {
        $rules = [
            'main_specialist_id' => 'required|exists:main_specialists,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $main_specialist = \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->first();
            if (!is_object($main_specialist)){
                return response()->json(['status' => 404, 'message' => 'main specialist Not Found', 'errors' => ['main specialist Not Found']], 404);
            }else{
                return response()->json(['status' => 200, 'data' => $main_specialist->toArray()], 200);
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
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $main_specialist = \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->first();
            if (!is_object($main_specialist)){
                return response()->json(['status' => 404, 'message' => 'main specialist Not Found', 'errors' => ['main specialist Not Found']], 404);
            }else{
                \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->update([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en
                ]);

                return response()->json(['status' => 200, 'message' => 'updated'], 200);
            }
        }
    }

    function delete(Request $request) {
        $rules = [
            'main_specialist_id' => 'required|exists:main_specialists,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $main_specialist = \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->first();
            if (!is_object($main_specialist)){
                return response()->json(['status' => 404, 'message' => 'main specialist Not Found', 'errors' => ['main specialist Not Found']]);
            }else{
                $main_specialist = \App\Models\MainSpecialist::where('id', $request->main_specialist_id)->delete();
                return response()->json(['status' => 200, 'message' => 'deleted'], 200);
            }
        }
    }
}
