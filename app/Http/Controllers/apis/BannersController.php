<?php

namespace App\Http\Controllers\apis;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class BannersController extends Controller {

    function index(Request $request) {
        $banners =new \App\Models\Banner;
     
        $banners = $banners->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $banners->toArray()]);
    }

    function add(Request $request) {
        $rules = [
            
            'image' => 'required|image'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $product = new \App\Models\Banner();
     
        $product->image = $this->uploadfile($request->image);
        
        $product->save();
        return response()->json(['status' => 200, 'message' => 'added']);
    }

    function display(Request $request) {
        $rules = [
            'banner_id' => 'required|exists:banners,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $banner = \App\Models\Banner::where('id', $request->banner_id)->first();
        if (!is_object($banner))
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => ['product Not Found']]);
        return response()->json(['status' => 200, 'data' => $banner->toArray()]);
    }

    function edit(Request $request) {
        $rules = [
            'image' => 'required',
            
            'banner_id' => 'required|exists:banners,id'
        ];
        if ($request->has('image'))
            $rules['image'] = 'required|image';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $product = \App\Models\Banner::where('id', $request->banner_id)->first();
        if (!is_object($product))
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => ['product Not Found']]);
   if ($request->hasFile('image'))
        $product->image = $this->uploadfile($request->image);
   
        $product->save();
        return response()->json(['status' => 200, 'message' => 'updated']);
    }

    function delete(Request $request) {
        $rules = [
            'banner_id' => 'required|exists:banners,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $product = \App\Models\Banner::where('id', $request->banner_id)->first();
        if (!is_object($product))
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => ['product Not Found']]);
        $product = \App\Models\Banner::where('id', $request->banner_id)->delete();
        return response()->json(['status' => 200, 'message' => 'deleted']);
    }

    function all(Request $request) {
        $products = \App\Models\Product::orderBy('id', 'desc');
        if ($request->family_id!='')
            $products = $products->where('user_id', $request->family_id);
        if ($request->category_id!='')
            $products = $products->where('category_id', $request->category_id);
        $products = $products->get();
        $productsarr = [];
        foreach ($products as $key => $product) {
            $productsarr[$key] = $product->toArray();
            $productsarr[$key]['is_fav'] = 0;
            if (auth()->guard('api')->check()) {
                $wishlist = \App\Models\Wishlist::where('user_id', $request->user()->id)->where('product_id', $product->id)->first();
                if (is_object($wishlist))
                    $productsarr[$key]['is_fav'] = 1;
            }
        }
        return response()->json(['status' => 200, 'data' => $productsarr]);
    }

    function show(Request $request) {
        $rules = [
            'product_id' => 'required|exists:products,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => 500, 'message' => 'Invalide Data', 'errors' => $validator->errors()->all()]);
        $productsarr = [];
        $product = \App\Models\Product::where('id', $request->product_id)->first();

        $productsarr = $product->toArray();
        $productsarr['is_fav'] = 0;
        if (auth()->guard('api')->check()) {
            $wishlist = \App\Models\Wishlist::where('user_id', $request->user()->id)->where('product_id', $product->id)->first();
            if (is_object($wishlist))
                $productsarr['is_fav'] = 1;
        }
        $related= \App\Models\Product::where('id','!=',$product->id)->where('user_id',$product->user_id)->orderBy('id','desc')->get();
        
        return response()->json(['status' => 200, 'data' => $productsarr,'related'=>$related->toArray()]);
    }

    private function uploadfile($file) {
        $path = 'uploads/banners';
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
