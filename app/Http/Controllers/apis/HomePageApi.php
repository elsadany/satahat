<?php

namespace App\Http\Controllers\apis;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Resources\HomepageResourse;
use Elsayednofal\BackendLanguages\Models\Languages;
use App\Models\Settings;
use App\Models\ContactUs;
use App\Http\Resources\GeneralTagsResourse;
use App\Models\Contact;

class HomePageApi extends Controller {

 
   
    function contact(Request $request){
        $validator = \Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'phone' => 'required|numeric',
                    'title' => 'required',
                    'message' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $contact=new Contact();
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->email=$request->email;
        $contact->title=$request->title;
        $contact->message=$request->message;
        $contact->save();
         return response()->json(['status'=>true,'message'=>'success'], 200);
    }
}
