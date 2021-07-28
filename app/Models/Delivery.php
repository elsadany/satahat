<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $appends=['id_imagePath','carIdImagePath','rating'];
    protected $with=['brand','rates'];
    use HasFactory;
    protected $table='delivery';
    public $timestamps=false;
    public $primaryKey='user_id';
    protected $guarded=['id'];
    
    function getIdImagePathAttribute(){
        if($this->id_image!='')
            url($this->image_id);
        return '';
    }
    function getCarIdImagePathAttribute(){
        if($this->car_id_image!='')
            url($this->image_id);
        return '';
    }
    function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    function rates(){
        return $this->hasMany(Rate::class,'delivery_id','user_id')->orderBy('id','desc');
    }
    function getRatingAttribute(){
        if($this->rates()->count()<1)
            return 0;
        else{
            return round($this->rates()->sum('rate')/$this->rates()->count());
        }
    }
}
