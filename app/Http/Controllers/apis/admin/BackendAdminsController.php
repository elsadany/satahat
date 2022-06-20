<?php

namespace App\Http\Controllers\apis\admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminSections;
use Illuminate\Support\Facades\Hash;
use Validator;

class BackendAdminsController extends Controller {

    function index(Request $request) {
        $admins =\App\Models\Admin::where('id','!=',$request->user()->id);
     
        $admins = $admins->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $admins->toArray()]);
    }

    function add(Request $request) {
        $rules = [
            'image' => 'required|image',
            'name'=>'required',
            'email'=>'required|unique:admins,email',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password',
            'role'=>'required',
            'sections'=>'required|array',
            'sections.*'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $admin = new \App\Models\Admin();
     
        $admin->image = $this->uploadfile($request->image);
        $admin->name=$request->name;
        $admin->email=$request->email;
        $admin->password=Hash::make($request->password);
        $admin->role=$request->role;
        $admin->save();
        foreach($request->sections as $saction){
            $section=new AdminSections();
            $section->section=$saction;
            $section->admin_id=$admin->id;
            $section->save();
        }
        return response()->json(['status' => true, 'message' => 'admin added']);
    }

    function display(Request $request) {
        $rules = [
            'admin_id' => 'required|exists:admins,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $admin = \App\Models\Admin::where('id', $request->admin_id)->first();
        if (!is_object($admin))
            return response()->json(['status' => false, 'message' => 'admin not found', 'errors' => ['admin Not Found']]);
        return response()->json(['status' => true, 'data' => $admin->toArray()]);
    }

    function edit(Request $request) {
        $rules = [
           
            'name'=>'required',
            'email'=>'required',
            'role'=>'required',
         
            'admin_id' => 'required|exists:admins,id',
            'sections'=>'required|array',
            'sections.*'=>'required'
        ];
        if ($request->hasFile('image'))
            $rules['image'] = 'required|image';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $admin = \App\Models\Admin::where('id', $request->admin_id)->where('id','!=',$request->user()->id)->first();
        if (!is_object($admin))
            return response()->json(['status' => false, 'message' => 'admin not found', 'errors' => ['admin Not Found']]);
            if($request->email!=$admin->email)
            $rules['email']='required|unique:admins,email';
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
                return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
   if ($request->hasFile('image'))
        $admin->image = $this->uploadfile($request->image);
  
        $admin->name=$request->name;
        $admin->email=$request->email;
        if($request->password!='')
        $admin->password=Hash::make($request->password);
        $admin->role=$request->role;

        $admin->save();
        AdminSections::where('admin_id',$admin->id)->delete();
        foreach($request->sections as $saction){
            $section=new AdminSections();
            $section->section=$saction;
            $section->admin_id=$admin->id;
            $section->save();
        }
        return response()->json(['status' => true, 'message' => 'updated']);
    }

    function delete(Request $request) {
        $rules = [
            'admin_id' => 'required|exists:admins,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $admin = \App\Models\Admin::where('id', $request->admin_id)->where('id','!=',$request->user()->id)->first();
        if (!is_object($admin))
            return response()->json(['status' => false, 'message' => 'admin not found', 'errors' => ['admin Not Found']]);
        $admin = \App\Models\Admin::where('id', $request->admin_id)->delete();
        return response()->json(['status' => true, 'message' => 'deleted']);
    }

   
    private function uploadfile($file) {
        $path = 'uploads/admins';
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
