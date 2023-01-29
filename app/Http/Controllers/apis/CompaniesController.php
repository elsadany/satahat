<?php

namespace App\Http\Controllers\apis;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompaniesHarbor;
use App\Models\Order;
use App\Models\OrdersFiles;
use App\Models\OrdersTransaction;
use App\Models\PromoCode;
use Carbon\Carbon;
use Validator;

class CompaniesController extends Controller
{

    function index(Request $request)
    {
        $rules = [
            'type' => 'required|boolean',
            'weight' => 'required|integer'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);


        $price = 0;
        if ($request->type == 1)
            $price = 14 * $request->weight;
        else
            $price = 368 * $request->weight;
        $company = \App\Models\Company::first();

        return response()->json(['status' => true, 'price' => $price, 'data' => $company->toArray()]);
    }
    function checkPromo(Request $request)
    {
        $rules = [
            'code' => 'required|exists:promo_codes,code',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $promo = PromoCode::where('code', $request->code)->whereDate('expire_at', '>=', Carbon::now())->first();
        if (!is_object($promo))
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Promocode not found or expired']]);
        return response()->json(['status' => true, 'data' => $promo->toArray()]);
    }

    function bookCompany(Request $request)
    {
        $rules = [
            'china_harbor_id' => 'required|exists:china_harbors,id',
            'saudi_harbor_id' => 'required|exists:saudi_harbors,id',
            'type' => 'required|boolean',
            'shipment_type' => 'required|exists:shipment_types,id',
            'weight' => 'required|integer',
            'company_id' => 'required|exists:companies,id',
            'length' => 'sometimes|nullable',
            'width' => 'sometimes|nullable',
            'height' => 'sometimes|nullable',
            'invoice' => 'required',
            'list' => 'required',
            'code' => 'sometimes|nullable|exists:promo_codes,code',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);

        if ($request->code != '') {
            $promo = PromoCode::where('code', $request->code)->whereDate('expire_at', '>=', Carbon::now())->first();
            if (!is_object($promo))
                return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Promocode not found or expired']]);
        }
        $order = new Order();
        $order->saudi_harbor_id = $request->saudi_harbor_id;
        $order->china_harbor_id = $request->china_harbor_id;
        $order->type = $request->type;
        $order->shipment_type_id = $request->shipment_type;
        $order->weight = $request->weight;
        $order->company_id = $request->company_id;
        $order->length = $request->length;
        $order->width = $request->width;
        $order->weight = $request->weight;
        $order->height = $request->height;
        $order->user_id = $request->user()->id;

        if ($request->hasFile('invoice'))
            $order->invoice = $this->uploadfile($request->file('invoice'));
        if ($request->hasFile('list'))
            $order->list = $this->uploadfile($request->file('list'));
        $price = 0;
        if ($request->type == 1)
            $price = 14 * $request->weight;
        else
            $price = 368 * $request->weight;
        $order->shipping_price = $price;
        if ($request->code != '') {
            $order->discount_precentage = $promo->discount_precentage;
            $order->price = $price - (($price * $promo->discount_precentage) / 100);
        } else {
            $order->price = $price;
        }
        $order->status_id = 0;

        $order->save();
        $time = Carbon::now();
        $order->order_refrence = datE('Y', strtotime($time)) . date('m', strtotime($time)) . date('d', strtotime($time)) . $order->id;
        $order->save();
        if($request->has('files')){
            foreach($request->get('files') as $one_file){
                $file=new OrdersFiles();
                $file->file=$this->uploadfile($one_file);
                $file->order_id=$order->id;
                $file->save();
            }
        }
        $order = Order::find($order->id);
        return response()->json(['status' => true, 'message' => 'success', 'data' => $order->toArray()]);
    }
    function getUserOrders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->where('payed',1)->latest('id');
        if ($request->status_id != '')
            $orders = $orders->where('status_id', $request->status_id);
        $orders = $orders->paginate(10);
        return response()->json(['status' => 200, 'data' => $orders->toArray(), 'message' => 'success']);
    }
    function cancel(Request $request)
    {
        $rules = ['order_id' => 'required|exists:orders,id'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($order))
            return response()->json(['status' => false, 'errors' => ['Order not Found']]);
        if ($order->canceled == 1)
            return response()->json(['status' => false, 'errors' => ['Order already canceled']]);
        if ($order->statu > 1)
            return response()->json(['status' => false, 'errors' => ['Order already shippend can`t canceled']]);
        $order->canceled = 1;
        $order->save();
        $payed = OrdersTransaction::where('order_id', $order->id)->where('user_id', $request->user()->id)->sum('payed');
        $user = $request->user();
        $user->balance = +$payed;
        return response()->json(['status' => true, 'message' => 'canceled']);
    }
    function pay(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($order))
            return response()->json(['status' => false, 'errors' => ['Order not Found']]);
        $idorder = $order->id; //Customer Order ID


        $terminalId = "ipe"; // Will be provided by URWAY
        $password = "ip_7554@URWAY"; // Will be provided by URWAY
        $merchant_key = "19fa802b3a3656020a650c60e2d7f5f3bef5bd38fa1dfafede94a84d1b11d62d"; // Will be provided by URWAY
        $currencycode = "SAR";
        $amount = $order->price * 3.7575 *.5;
        $amount = number_format((float)$amount, 2, '.', '');
        $ipp = $this->get_server_ip();
        //Generate Hash
        $txn_details = $idorder . '|' . $terminalId . '|' . $password . '|' . $merchant_key . '|' . $amount . '|' . $currencycode;
        $hash = hash('sha256', $txn_details);


        $fields = array(
            'trackid' => $idorder,
            'terminalId' => $terminalId,
            'customerEmail' => $order->user->email,
            'action' => "1",  // action is always 1 
            'merchantIp' => $ipp,
            'password' => $password,
            'currency' => $currencycode,
            'country' => "SA",
            'amount' => $amount,
            "udf1"              => "Test1",
            "udf2"              => url('api/response'), //Response page URL
            "udf3"              => "",
            "udf4"              => "",
            "udf5"              => "Test5",
            'requestHash' => $hash  //generated Hash  
        );
        $data = json_encode($fields);

        $ch = curl_init('https://payments.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest'); // Will be provided by URWAY
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post 
        $server_output = curl_exec($ch);

        //close connection 
        curl_close($ch);
        $result = json_decode($server_output);
        if (!empty($result->payid) && !empty($result->targetUrl)) {
            $url = $result->targetUrl . '?paymentid=' .  $result->payid;
            return response()->json(['status' => true, 'url' => $url]);
        } else {



            return response()->json(['status' => false, 'message' => 'There are problem please call the support']);
        }
    }
    function acceptChange(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',
            'payed' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($order))
            return response()->json(['status' => false, 'errors' => ['Order not Found']]);
        if ($order->is_change == 0)
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => ['Order price isn`t change']]);
        $order->accept_change = 1;
        $order->price = $order->calculated_price_after_discount;
        $order->save();
        return response()->json(['status' => true, 'message' => 'success']);
    }
    function payremain(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',
            'payed' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'message' => 'Invalid Data', 'errors' => $validator->errors()->all()]);
        $order = Order::where('id', $request->order_id)->where('user_id', $request->user()->id)->first();
        if (!is_object($order))
            return response()->json(['status' => false, 'errors' => ['Order not Found']]);
        $payed = new OrdersTransaction();
        $payed->payed = $request->payed;
        $payed->user_id = $request->user()->id;
        $payed->order_id = $request->order_id;
        $payed->save();
        $order->payed = 1;
        $order->save();
        return response()->json(['status' => true, 'message' => 'Payed']);
    }
    private function uploadfile($file)
    {
        $path = 'uploads/users';
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

    private function generateRandom($length = 11)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = time();
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    function get_server_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    function response(Request $request)
    {
        $order = Order::find($request->TrackId);

        if ($request->ResponseCode == '000') {
            $order->payed = 1;
            $order->save();
            return redirect()->away('https://ipe2w.com/paymentsuccess');
        }

        return redirect()->away('https://ipe2w.com/paymentfail');
    }
}
