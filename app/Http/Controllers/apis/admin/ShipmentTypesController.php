<?php

namespace App\Http\Controllers\apis\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ShipmentTypesController extends Controller {

    function index(Request $request) {
        $shipment_types =new \App\Models\ShipmentType;
     
        $shipment_types = $shipment_types->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $shipment_types->toArray()]);
    }

    function add(Request $request) {
        $rules = [
       
            'name_ar'=>'required',
            'name_en'=>'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $shipment_type = new \App\Models\ShipmentType();
     
      
        $shipment_type->name_ar=$request->name_ar;
        $shipment_type->name_en=$request->name_en;
       
        $shipment_type->save();
        return response()->json(['status' => true, 'message' => 'shipment_type added']);
    }

    function display(Request $request) {
        $rules = [
            'shipment_type_id' => 'required|exists:shipment_types,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $shipment_type = \App\Models\ShipmentType::where('id', $request->shipment_type_id)->first();
        if (!is_object($shipment_type))
            return response()->json(['status' => false, 'message' => 'shipment_type not found', 'errors' => ['shipment_type Not Found']]);
        return response()->json(['status' => true, 'data' => $shipment_type->toArray()]);
    }

    function edit(Request $request) {
        $rules = [
           
            'name_ar'=>'required',
            'name_en'=>'required',
            'shipment_type_id' => 'required|exists:shipment_types,id'
        ];
        if ($request->hasFile('image'))
            $rules['image'] = 'required|image';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $shipment_type = \App\Models\ShipmentType::where('id', $request->shipment_type_id)->first();
        if (!is_object($shipment_type))
            return response()->json(['status' => false, 'message' => 'shipment_type not found', 'errors' => ['shipment_type Not Found']]);
  
   $shipment_type->name_ar=$request->name_ar;
        $shipment_type->name_en=$request->name_en;
      
        $shipment_type->save();
        return response()->json(['status' => true, 'message' => 'updated']);
    }

    function delete(Request $request) {
        $rules = [
            'shipment_type_id' => 'required|exists:shipment_types,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $shipment_type = \App\Models\ShipmentType::where('id', $request->shipment_type_id)->first();
        if (!is_object($shipment_type))
            return response()->json(['status' => false, 'message' => 'shipment_type not found', 'errors' => ['shipment_type Not Found']]);
        $shipment_type = \App\Models\ShipmentType::where('id', $request->shipment_type_id)->delete();
        return response()->json(['status' => true, 'message' => 'deleted']);
    }

   
    private function uploadfile($file) {
        $path = 'uploads/shipment_types';
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
