<?php

namespace App\Http\Controllers\apis;

use Elsayednofal\BackendLanguages\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class SelectsController extends Controller {

   
   
    function getBrands(Request $request){
        $brands= \App\Models\Brand::all();
        return response()->json(['status' => 200, 'data' => $brands->toArray()], 200);
    }
    function getJobs(Request $request){
        $jobs= \App\Models\Job::all();
        return response()->json(['status' => 200, 'data' => $jobs->toArray()], 200);
    }
    function getcities(Request $request){
        $cities= \App\Models\City::all();
        return response()->json(['status' => 200, 'data' => $cities->toArray()], 200);
    }
    function getMainspecialists(Request $request){
    

        $specialists= \App\Models\MainSpecialist::orderBy('id','desc')->get();
        return response()->json(['status' => 200, 'data' => $specialists->toArray()], 200);
    }
    function getSecondaryspecialists(Request $request){
          $rules=[
          'specialist_id'=>'required|exists:secondary_specialists,id'  
        ];
         $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
      
        $specialists= \App\Models\SecondarySpecialist::where('main_specialist_id',$request->specialist_id)->get();
        return response()->json(['status' => 200, 'data' => $specialists->toArray()], 200);
    }
    
    function getBanners(Request $request){
        $banners= \App\Models\Banner::all();
        return response()->json(['status'=>200,'data'=>$banners->toArray()], 200);
    }

}
