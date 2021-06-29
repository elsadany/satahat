<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AppSettingController extends Controller
{
    public function index(Request $request)
    {
      $setting= \App\Models\AppSetting::first();
        return response()->json(['status' => 200, 'data' => $setting->toArray()]);
    }

    function update(Request $request) {
        $rules = [
            'vat_precent' => 'required|numeric',
            'app_precent' => 'required|numeric'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $setting = new \App\Models\AppSetting();
        

        $setting->vat_precent = $request->vat_precent;
        $setting->app_precent = $request->app_precent;
        
        $setting->save();
        return response()->json(['status' => 200, 'message' => 'updated']);
    }


}
