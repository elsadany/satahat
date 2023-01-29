<?php

namespace App\Http\Controllers\apis\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrdersTransaction;
use Illuminate\Http\Request;
use Validator;

class OrdersController extends Controller
{
    function index(Request $request)
    {
        $orders = \App\Models\Order::where('payed', 1);
        if($request->order_refrence!='')
        $orders=$orders->where('order_refrence',$request->order_refrence);
         if ($request->order_id != '')

            $orders = $orders->where('id', $request->order_id);
        if ($request->status_id != '')

            $orders = $orders->where('status_id', $request->status_id);
        $orders = $orders->orderBy('id', 'desc')->paginate(20);
        return response()->json(['status' => true, 'data' => $orders->toArray()], 200);
    }
    function changToDeliver(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',



        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order->status_id > 0)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Already delivered of finished']]);
        if ($order->canceled == 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already Order Canceled']]);
        if ($order->payed != 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Order didn`t payed']]);
        $order->status_id = 1;
        $order->save();

        return response()->json(['status' => true, 'data' => $order->toArray()], 200);
    }
    function confirmOrder(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order->status_id > 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already status changed']]);
        if ($order->canceled == 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already Order Canceled']]);

        $order->status_id = 1;
        $order->save();
        return response()->json(['status' => true, 'data' => $order->toArray()], 200);
    }
    function cancelOrder(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order->status_id > 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already status changed']]);

        $order->canceled = 1;
        $order->save();
        return response()->json(['status' => true, 'data' => $order->toArray()], 200);
    }
    function recieveChina(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order->status_id > 2)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already status changed']]);
        if ($order->canceled == 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already Order Canceled']]);

        $order->status_id = 2;
        $order->save();
        return response()->json(['status' => true, 'data' => $order->toArray()], 200);
    }
    function checkPrice(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',
            'is_changed' => 'required|boolean',
            'calculated_price' => 'sometimes|nullable'

        ];
        if ($request->is_changed)
            $rules['calculated_price'] = 'required';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order->status_id < 2)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['change Status First']]);
        if ($order->canceled == 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already Order Canceled']]);

        if ($request->calculated_price == $order->price)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Calculated Price must not equal to current price']]);
          $order->status_id=2;
      if($request->is_changed==1) {
          $order->is_changed = $request->is_changed;
          $order->calculated_price = $request->calculated_price;
          $order->calculated_price_after_discount = $request->calculated_price - ($request->calculated_price * $order->discount_precentage / 100);
      }
          $order->save();
        return response()->json(['status' => true, 'data' => $order->toArray()], 200);
    }
    function changeStatus(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',
            'status_id' => 'required|numeric|min:|max:6',


        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order->status_id < 2)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['change Status First']]);
        if ($order->canceled == 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already Order Canceled']]);
        if ($order->is_changed == 1 && $order->accept_change == 0)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Cahnge price not Approved yet']]);
        if ($order->payed != 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Order didn`t payed']]);
        $order->status_id = $request->status_id;
        $order->save();

        return response()->json(['status' => true, 'data' => $order->toArray()], 200);
    }
    function finish(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',



        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order->status_id != 7)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['change to deliver  First']]);
        if ($order->canceled == 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['already Order Canceled']]);

        if ($order->payed != 1)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Order didn`t payed']]);
        $order->status_id = 7;
        $order->save();

        return response()->json(['status' => true, 'data' => $order->toArray()], 200);
    }
    function transactions()
    {
        $transactions = OrdersTransaction::latest('id')->with(['user', 'order'])->paginate(20);
        return response()->json(['status' => true, 'data' => $transactions->toArray()], 200);
    }
}
