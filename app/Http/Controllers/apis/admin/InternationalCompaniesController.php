<?php

namespace App\Http\Controllers\apis\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class InternationalCompaniesController extends Controller {

    function index(Request $request) {
        $companies =new \App\Models\InternationalCompany;
     
        $companies = $companies->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $companies->toArray()]);
    }

    function add(Request $request) {
        $rules = [
            'image' => 'required|image',
            'name_ar'=>'required',
            'name_en'=>'required',
            'price'=>'required',
            'insaurance'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $company = new \App\Models\InternationalCompany();
     
        $company->image = $this->uploadfile($request->image);
        $company->name_ar=$request->name_ar;
        $company->name_en=$request->name_en;
        $company->description_ar=$request->description_ar;
        $company->description_en=$request->description_en;
        $company->insaurance=$request->insaurance;
        $company->price=$request->price;
        $company->save();
        return response()->json(['status' => true, 'message' => 'company added']);
    }

    function display(Request $request) {
        $rules = [
            'company_id' => 'required|exists:international_companies,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $company = \App\Models\InternationalCompany::where('id', $request->company_id)->first();
        if (!is_object($company))
            return response()->json(['status' => false, 'message' => 'company not found', 'errors' => ['company Not Found']]);
        return response()->json(['status' => true, 'data' => $company->toArray()]);
    }

    function edit(Request $request) {
        $rules = [
           
            'name_ar'=>'required',
            'name_en'=>'required',
            'company_id' => 'required|exists:international_companies,id',
            'price'=>'required',
            'insaurance'=>'required'
        ];
        if ($request->hasFile('image'))
            $rules['image'] = 'required|image';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $company = \App\Models\InternationalCompany::where('id', $request->company_id)->first();
        if (!is_object($company))
            return response()->json(['status' => false, 'message' => 'company not found', 'errors' => ['company Not Found']]);
   if ($request->hasFile('image'))
        $company->image = $this->uploadfile($request->image);
   $company->name_ar=$request->name_ar;
        $company->name_en=$request->name_en;
        $company->description_ar=$request->description_ar;
        $company->description_en=$request->description_en;
        $company->insaurance=$request->insaurance;
        $company->price=$request->price;
        $company->save();
        return response()->json(['status' => true, 'message' => 'updated']);
    }

    function delete(Request $request) {
        $rules = [
            'company_id' => 'required|exists:international_companies,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $company = \App\Models\InternationalCompany::where('id', $request->company_id)->first();
        if (!is_object($company))
            return response()->json(['status' => false, 'message' => 'company not found', 'errors' => ['company Not Found']]);
        $company = \App\Models\InternationalCompany::where('id', $request->company_id)->delete();
        return response()->json(['status' => true, 'message' => 'deleted']);
    }

   
    private function uploadfile($file) {
        $path = 'uploads/companies';
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
