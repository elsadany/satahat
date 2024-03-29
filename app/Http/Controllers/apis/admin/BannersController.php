<?php

namespace App\Http\Controllers\apis\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class BannersController extends Controller {

    function index(Request $request) {
        $banners =new \App\Models\Banner;
     
        $banners = $banners->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $banners->toArray()]);
    }

    function add(Request $request) {
        $rules = [
            'image' => 'required|image',
            'title_ar'=>'required',
            'title_en'=>'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $banner = new \App\Models\Banner();
     
        $banner->image = $this->uploadfile($request->image);
        $banner->title_ar=$request->title_ar;
        $banner->title_en=$request->title_en;
        $banner->description_ar=$request->description_ar;
        $banner->description_en=$request->description_en;
        $banner->save();
        return response()->json(['status' => true, 'message' => 'banner added']);
    }

    function display(Request $request) {
        $rules = [
            'banner_id' => 'required|exists:banners,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $banner = \App\Models\Banner::where('id', $request->banner_id)->first();
        if (!is_object($banner))
            return response()->json(['status' => false, 'message' => 'banner not found', 'errors' => ['banner Not Found']]);
        return response()->json(['status' => true, 'data' => $banner->toArray()]);
    }

    function edit(Request $request) {
        $rules = [
           
            'title_ar'=>'required',
            'title_en'=>'required',
            'banner_id' => 'required|exists:banners,id'
        ];
        if ($request->hasFile('image'))
            $rules['image'] = 'required|image';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $banner = \App\Models\Banner::where('id', $request->banner_id)->first();
        if (!is_object($banner))
            return response()->json(['status' => false, 'message' => 'banner not found', 'errors' => ['banner Not Found']]);
   if ($request->hasFile('image'))
        $banner->image = $this->uploadfile($request->image);
   $banner->title_ar=$request->title_ar;
        $banner->title_en=$request->title_en;
        $banner->description_ar=$request->description_ar;
        $banner->description_en=$request->description_en;
        $banner->save();
        return response()->json(['status' => true, 'message' => 'updated']);
    }

    function delete(Request $request) {
        $rules = [
            'banner_id' => 'required|exists:banners,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $banner = \App\Models\Banner::where('id', $request->banner_id)->first();
        if (!is_object($banner))
            return response()->json(['status' => false, 'message' => 'banner not found', 'errors' => ['banner Not Found']]);
        $banner = \App\Models\Banner::where('id', $request->banner_id)->delete();
        return response()->json(['status' => true, 'message' => 'deleted']);
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

    private function uploadbasfile($file) {
        $path = 'uploads/products';
        if (!file_exists($path)) {
            mkdir($path, 0775);
        }
        $datepath = date('m-Y', strtotime(\Carbon\Carbon::now()));
        if (!file_exists($path . '/' . $datepath)) {
            mkdir($path . '/' . $datepath, 0775);
        }
        $newdir = $path . '/' . $datepath;
        $exten = 'png';
        $filename = $this->generateRandom($length = 15);
        $filename = $filename . '.' . $exten;
        $filedate = base64_decode($file);

        file_put_contents($newdir . '/' . $filename, $filedate);

        return $newdir . '/' . $filename;
    }

}
