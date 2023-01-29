<?php

namespace App\Models;

use App\Models\Cart;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory;
    protected $guarded=['password','id'];
    protected $appends=['imagePath','orders','shipped','kgs','cbms'];
    protected $hidden=['password','parent','created_at','updated_at','mail_confirmed',
        'reset_password_token','remember_token','image'];
   
    
            function getImagePathAttribute() {
        if ($this->image != '') {
            if (strpos($this->image, "http") !== false)
                return $this->image;
            else if (strstr($this->image,'uploads'))
                return url($this->image);
            
        }
        return 'https://www.w3schools.com/howto/img_avatar.png';
    }
    function getOrdersAttribute(){
        return Order::where('user_id',$this->id)->where('status_id','<',8)->count();
    }
    function getShippedAttribute(){
        return Order::where('user_id',$this->id)->where('status_id',8)->count();
    }
       function getKgsAttribute(){
        return Order::where('type',1)->where('user_id',$this->id)->sum('weight');
    }
       function getCbmsAttribute(){
        return Order::where('type',0)->where('user_id',$this->id)->sum('weight');
    }
 
    
}
