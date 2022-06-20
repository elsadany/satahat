<?php

namespace App\Http\Controllers\apis\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class TestimonialsController extends Controller {

    function index(Request $request) {
        $testimonials =new \App\Models\Testimonial;
     
        $testimonials = $testimonials->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $testimonials->toArray()]);
    }

    function add(Request $request) {
        $rules = [
            
            'name_ar'=>'required',
            'name_en'=>'required',
            'description_ar'=>'required',
            'description_en'=>'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $testimonial = new \App\Models\Testimonial();
     
        $testimonial->name_ar=$request->name_ar;
        $testimonial->name_en=$request->name_en;
        $testimonial->description_ar=$request->description_ar;
        $testimonial->description_en=$request->description_en;
        $testimonial->save();
        return response()->json(['status' => true, 'message' => 'testimonial added']);
    }

    function display(Request $request) {
        $rules = [
            'testimonial_id' => 'required|exists:testimonials,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $testimonial = \App\Models\Testimonial::where('id', $request->testimonial_id)->first();
        if (!is_object($testimonial))
            return response()->json(['status' => false, 'message' => 'testimonial not found', 'errors' => ['testimonial Not Found']]);
        return response()->json(['status' => true, 'data' => $testimonial->toArray()]);
    }

    function edit(Request $request) {
        $rules = [
            'description_ar'=>'required',
            'description_en'=>'required',
            'name_ar'=>'required',
            'name_en'=>'required',
            'testimonial_id' => 'required|exists:testimonials,id'
        ];
      
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $testimonial = \App\Models\Testimonial::where('id', $request->testimonial_id)->first();
        if (!is_object($testimonial))
            return response()->json(['status' => false, 'message' => 'testimonial not found', 'errors' => ['testimonial Not Found']]);
   if ($request->hasFile('image'))
        $testimonial->image = $this->uploadfile($request->image);
   $testimonial->name_ar=$request->name_ar;
        $testimonial->name_en=$request->name_en;
        $testimonial->description_ar=$request->description_ar;
        $testimonial->description_en=$request->description_en;
        $testimonial->save();
        return response()->json(['status' => true, 'message' => 'updated']);
    }

    function delete(Request $request) {
        $rules = [
            'testimonial_id' => 'required|exists:testimonials,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $testimonial = \App\Models\Testimonial::where('id', $request->testimonial_id)->first();
        if (!is_object($testimonial))
            return response()->json(['status' => false, 'message' => 'testimonial not found', 'errors' => ['testimonial Not Found']]);
        $testimonial = \App\Models\Testimonial::where('id', $request->testimonial_id)->delete();
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
