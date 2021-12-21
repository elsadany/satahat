<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class SecondarySpecialistsController extends Controller
{
    function all(Request $request) {
        $secondary_specialists =new \App\Models\SecondarySpecialist;
     
        $secondary_specialists = $secondary_specialists->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $secondary_specialists->toArray()], 200);
    }

    function create(Request $request) {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'main_specialist_id' => 'required|exists:main_specialists,id',
            'image' => 'required|image'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $secondary_specialist = new \App\Models\SecondarySpecialist;
            $secondary_specialist->name_ar = $request->name_ar;
            $secondary_specialist->name_en = $request->name_en;
            $secondary_specialist->main_specialist_id = $request->main_specialist_id;
            $secondary_specialist->image = $this->uploadfile($request->image);
            
            $secondary_specialist->save();
            return response()->json(['status' => 201, 'message' => 'added'], 201);
        }
    }

    function show(Request $request) {
        $rules = [
            'secondary_specialist_id' => 'required|exists:secondary_specialists,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }
        $secondary_specialist = \App\Models\SecondarySpecialist::where('id', $request->secondary_specialist_id)->first();
        if (!is_object($secondary_specialist)){
            return response()->json(['status' => 404, 'message' => 'secondary specialist Not Found', 'errors' => ['secondary specialist Not Found']], 404);
        }
        return response()->json(['status' => 200, 'data' => $secondary_specialist->toArray()], 200);
    }

    function edit(Request $request) {
        $rules = [
            'secondary_specialist_id' => 'required|exists:secondary_specialists,id',
            'name_ar' => 'required',
            'name_en' => 'required',
            'main_specialist_id' => 'required|exists:main_specialists,id',
        ];
        if ($request->hasFile('image')){
            $rules['image'] = 'required|image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }
            $secondary_specialist = \App\Models\SecondarySpecialist::where('id', $request->secondary_specialist_id)->first();
            if (!is_object($secondary_specialist)){
                return response()->json(['status' => 404, 'message' => 'secondary specialist Not Found', 'errors' => ['secondary specialist Not Found']], 404);
            }
            $image=$secondary_specialist->image;
                if ($request->hasFile('image'))
                    $image = $this->uploadfile($request->image);
        
                    \App\Models\SecondarySpecialist::where('id', $request->secondary_specialist_id)->update([
                        'name_ar' => $request->name_ar,
                        'name_en' => $request->name_en,
                        'main_specialist_id' => $request->main_specialist_id,
                        'image' => $image
                    ]);
        
                    return response()->json(['status' => 200, 'message' => 'updated'], 200);
                
        
               
              
          
    }

    function delete(Request $request) {
        $rules = [
            'secondary_specialist_id' => 'required|exists:secondary_specialists,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $secondary_specialist = \App\Models\SecondarySpecialist::where('id', $request->secondary_specialist_id)->first();
            if (!is_object($secondary_specialist)){
                return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => ['secondary specialist Not Found']]);
            }else{
                $secondary_specialist = \App\Models\SecondarySpecialist::where('id', $request->secondary_specialist_id)->delete();
                return response()->json(['status' => 200, 'message' => 'deleted']);
            }
        }
    }

    private function uploadfile($file) {
        $path = 'uploads/secondary_specialists';
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
