<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Validator;

class JobsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }
        $job = new Job();
        $job->name_ar = $request->name_ar;
        $job->name_en = $request->name_en;
        $job->save();

        $response['status'] = 201;
        $response['message'] = 'success';
        $response['data'] = [
            'job' => $job->toArray()
        ];
        return response()->json($response, 201);
    }
}
