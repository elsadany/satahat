<?php

namespace App\Http\Controllers\apis;

use Elsayednofal\BackendLanguages\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class SelectsController extends Controller {

   
   
    function getBrands(Request $request){
        $brands= \App\Models\Brand::all();
        return response()->json(['status' => 200, 'data' => $brands->toArray()]);
    }
    function getJobs(Request $request){
        $jobs= \App\Models\Job::all();
        return response()->json(['status' => 200, 'data' => $jobs->toArray()]);
    }
    function getcities(Request $request){
        $cities= \App\Models\City::all();
        return response()->json(['status' => 200, 'data' => $cities->toArray()]);
    }
    function getMainspecialists(Request $request){
    

        $specialists= \App\Models\MainSpecialist::orderBy('id','desc')->get();
        return response()->json(['status' => 200, 'data' => $specialists->toArray()]);
    }
    function getSecondaryspecialists(Request $request){
          $rules=[
          'specialist_id'=>'required|exists:secondary_specialists,id'  
        ];
         $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
      
        $specialists= \App\Models\SecondarySpecialist::where('main_specialist_id',$request->specialist_id)->get();
        return response()->json(['status' => 200, 'data' => $specialists->toArray()]);
    }
    
    function getBanners(Request $request){
        $banners= \App\Models\Banner::all();
        return response()->json(['status'=>200,'data'=>$banners->toArray()]);
    }

}
