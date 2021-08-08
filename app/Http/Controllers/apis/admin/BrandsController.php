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
        return response()->json(['status' => 200, 'data' => $brands->toArray()], 200);
    }

    function create(Request $request) {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'image'=>'required|image'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        $brand = new \App\Models\Brand();
        $brand->image = $this->uploadfile($request->image);

        $brand->name_ar = $request->name_ar;
        $brand->name_en = $request->name_en;
        
        $brand->save();
        return response()->json(['status' => 201, 'message' => 'added'], 201);
    }

    function show(Request $request) {
        $rules = [
            'brand_id' => 'required|exists:brands,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $brand = \App\Models\Brand::where('id', $request->brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => 404, 'message' => 'brand not found', 'errors' => ['brand Not Found']], 404);
            }else{
                return response()->json(['status' => 200, 'data' => $brand->toArray()], 200);
            }
        }
    }

    function edit(Request $request) {
        $rules = [
            'brand_id' => 'required|exists:brands,id',
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
        if ($request->has('image'))
            $rules['image'] = 'required|image';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $brand = \App\Models\Brand::where('id', $request->brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => 404, 'message' => 'brand not found', 'errors' => ['brand Not Found']], 404);
            }else{
                $image=$brand->image;
                if ($request->hasFile('image'))
                    $image = $this->uploadfile($request->image);
                \App\Models\Brand::where('id', $request->brand_id)->update([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'image'=>$image
                ]);

                return response()->json(['status' => 200, 'message' => 'updated'], 200);
            }
        }
    }

    function delete(Request $request) {
        $rules = [
            'brand_id' => 'required|exists:brands,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $brand = \App\Models\Brand::where('id', $request->brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => 404, 'message' => 'brand not found', 'errors' => ['brand Not Found']], 404);
            }else{
                $brand = \App\Models\Brand::where('id', $request->brand_id)->delete();
                return response()->json(['status' => 200, 'message' => 'deleted'], 200);
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
