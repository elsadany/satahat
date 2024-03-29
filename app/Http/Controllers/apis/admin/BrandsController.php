<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BrandsController extends Controller
{
    function index(Request $request) {
        $brands =new \App\Models\CardBrand();
     
        $brands = $brands->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $brands->toArray()], 200);
    }

    function add(Request $request) {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'image'=>'required|image'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $brand = new \App\Models\CardBrand();
        $brand->image = $this->uploadfile($request->image);

        $brand->name_ar = $request->name_ar;
        $brand->name_en = $request->name_en;
        
        $brand->save();
        return response()->json(['status' => true, 'message' => 'added'] );
    }

    function display(Request $request) {
        $rules = [
            'card_brand_id' => 'required|exists:card_brands,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $brand = \App\Models\CardBrand::where('id', $request->card_brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => false, 'message' => 'brand not found', 'errors' => ['brand Not Found']]);
            }else{
                return response()->json(['status' => true, 'data' => $brand->toArray()]);
            }
        }
    }

    function edit(Request $request) {
        $rules = [
            'card_brand_id' => 'required|exists:card_brands,id',
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
        if ($request->hasFile('image'))
            $rules['image'] = 'required|image';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $brand = \App\Models\CardBrand::where('id', $request->card_brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => false, 'message' => 'brand not found', 'errors' => ['brand Not Found']]);
            }else{
                $image=$brand->image;
                if ($request->hasFile('image'))
                    $image = $this->uploadfile($request->image);
                \App\Models\CardBrand::where('id', $request->card_brand_id)->update([
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
            'card_brand_id' => 'required|exists:card_brands,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        }else{
            $brand = \App\Models\CardBrand::where('id', $request->card_brand_id)->first();
            if (!is_object($brand)){
                return response()->json(['status' => false, 'message' => 'brand not found', 'errors' => ['brand Not Found']]);
            }else{
                $brand = \App\Models\CardBrand::where('id', $request->card_brand_id)->delete();
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
