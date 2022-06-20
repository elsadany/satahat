<?php

namespace App\Http\Controllers\apis\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ServicesController extends Controller {

    function index(Request $request) {
        $services =new \App\Models\Service;
     
        $services = $services->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $services->toArray()]);
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
        $service = new \App\Models\Service();
     
        $service->image = $this->uploadfile($request->image);
        $service->title_ar=$request->title_ar;
        $service->title_en=$request->title_en;
        $service->description_ar=$request->description_ar;
        $service->description_en=$request->description_en;
        $service->save();
        return response()->json(['status' => true, 'message' => 'service added']);
    }

    function display(Request $request) {
        $rules = [
            'service_id' => 'required|exists:services,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $service = \App\Models\Service::where('id', $request->service_id)->first();
        if (!is_object($service))
            return response()->json(['status' => false, 'message' => 'service not found', 'errors' => ['service Not Found']]);
        return response()->json(['status' => true, 'data' => $service->toArray()]);
    }

    function edit(Request $request) {
        $rules = [
           
            'title_ar'=>'required',
            'title_en'=>'required',
            'service_id' => 'required|exists:services,id'
        ];
        if ($request->hasFile('image'))
            $rules['image'] = 'required|image';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $service = \App\Models\Service::where('id', $request->service_id)->first();
        if (!is_object($service))
            return response()->json(['status' => false, 'message' => 'service not found', 'errors' => ['service Not Found']]);
   if ($request->hasFile('image'))
        $service->image = $this->uploadfile($request->image);
   $service->title_ar=$request->title_ar;
        $service->title_en=$request->title_en;
        $service->description_ar=$request->description_ar;
        $service->description_en=$request->description_en;
        $service->save();
        return response()->json(['status' => true, 'message' => 'updated']);
    }

    function delete(Request $request) {
        $rules = [
            'service_id' => 'required|exists:services,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $service = \App\Models\Service::where('id', $request->service_id)->first();
        if (!is_object($service))
            return response()->json(['status' => false, 'message' => 'service not found', 'errors' => ['service Not Found']]);
        $service = \App\Models\Service::where('id', $request->service_id)->delete();
        return response()->json(['status' => true, 'message' => 'deleted']);
    }

   
    private function uploadfile($file) {
        $path = 'uploads/services';
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
