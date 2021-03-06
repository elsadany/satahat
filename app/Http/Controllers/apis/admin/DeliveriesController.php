<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class DeliveriesController extends Controller
{
    function all(Request $request) {
        $delivery_users =new \App\Models\User;
     
        $delivery_users = $delivery_users->where('type', '2')->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $delivery_users->toArray()], 200);
    }

    function show(Request $request) {
        $rules = [
            'delivery_user_id' => 'required|exists:users,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $delivery_user = \App\Models\User::where([
                'id' => $request->delivery_user_id,
                'type' => '2'
                ])->first();
            if (!is_object($delivery_user)){
                return response()->json(['status' => 404, 'message' => 'delivery user Not Found', 'errors' => ['delivery user Not Found']], 404);
            }else{
                return response()->json(['status' => 200, 'data' => $delivery_user->toArray()], 200);
            }
        }
    }
}
