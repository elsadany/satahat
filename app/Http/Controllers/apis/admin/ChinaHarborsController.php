<?php

namespace App\Http\Controllers\apis\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ChinaHarborsController extends Controller {

    function index(Request $request) {
        $china_harbors =new \App\Models\ChinaHarbor;
     
        $china_harbors = $china_harbors->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $china_harbors->toArray()]);
    }

    function add(Request $request) {
        $rules = [
            
            'name_ar'=>'required',
            'name_en'=>'required',
      
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $china_harbor = new \App\Models\ChinaHarbor();
     
        $china_harbor->name_ar=$request->name_ar;
        $china_harbor->name_en=$request->name_en;
   
        $china_harbor->save();
        return response()->json(['status' => true, 'message' => 'china_harbor added']);
    }

    function display(Request $request) {
        $rules = [
            'china_harbor_id' => 'required|exists:china_harbors,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $china_harbor = \App\Models\ChinaHarbor::where('id', $request->china_harbor_id)->first();
        if (!is_object($china_harbor))
            return response()->json(['status' => false, 'message' => 'china_harbor not found', 'errors' => ['china_harbor Not Found']]);
        return response()->json(['status' => true, 'data' => $china_harbor->toArray()]);
    }

    function edit(Request $request) {
        $rules = [
        
            'name_ar'=>'required',
            'name_en'=>'required',
            'china_harbor_id' => 'required|exists:china_harbors,id'
        ];
      
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $china_harbor = \App\Models\ChinaHarbor::where('id', $request->china_harbor_id)->first();
        if (!is_object($china_harbor))
            return response()->json(['status' => false, 'message' => 'china_harbor not found', 'errors' => ['china_harbor Not Found']]);

   $china_harbor->name_ar=$request->name_ar;
        $china_harbor->name_en=$request->name_en;

        $china_harbor->save();
        return response()->json(['status' => true, 'message' => 'updated']);
    }

    function delete(Request $request) {
        $rules = [
            'china_harbor_id' => 'required|exists:china_harbors,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $china_harbor = \App\Models\ChinaHarbor::where('id', $request->china_harbor_id)->first();
        if (!is_object($china_harbor))
            return response()->json(['status' => false, 'message' => 'china_harbor not found', 'errors' => ['china_harbor Not Found']]);
        $china_harbor = \App\Models\ChinaHarbor::where('id', $request->china_harbor_id)->delete();
        return response()->json(['status' => true, 'message' => 'deleted']);
    }

   
    private function uploadfile($file) {
        $path = 'uploads/testimonials';
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
