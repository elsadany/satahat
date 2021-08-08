<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ClientsController extends Controller
{
    function all(Request $request) {
        $clients =new \App\Models\User;
     
        $clients = $clients->where('type', '1')->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $clients->toArray()], 200);
    }

    function show(Request $request) {
        $rules = [
            'client_id' => 'required|exists:users,id'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(['status' => 422, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()], 422);
        }else{
            $client = \App\Models\User::where([
                'id' => $request->client_id,
                'type' => '1'
                ])->first();
            if (!is_object($client)){
                return response()->json(['status' => 404, 'message' => 'Invalid Data', 'errors' => ['client user Not Found']], 404);
            }else{
                return response()->json(['status' => 200, 'data' => $client->toArray()], 200);
            }
        }
    }
}
