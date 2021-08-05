<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $appends=['id_imagePath','driving_licenceImagePath','rating'];
    protected $with=['brand','rates','mainspecialist','secondaryspecialist'];
    use HasFactory;
    protected $table='delivery';
    public $timestamps=false;
    public $primaryKey='user_id';
    protected $guarded=['id'];
    
    function getIdImagePathAttribute(){
        if ($this->id_image != '') {
            if (strpos($this->id_image, "http") !== false)
                return $this->id_image;
            else if (strstr($this->id_image,'uploads'))
                return url($this->id_image);   
        }
    }
    function getDrivingLicenceImagePathAttribute(){
        if ($this->driving_licence != '') {
            if (strpos($this->driving_licence, "http") !== false)
                return $this->driving_licence;
            else if (strstr($this->driving_licence,'uploads'))
                return url($this->driving_licence);   
        }
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
    function mainspecialist(){
        return $this->belongsTo(MainSpecialist::class,'main_specialist_id');
    }
    function secondaryspecialist(){
        return $this->belongsTo(SecondarySpecialist::class,'secondary_specialist_id');
    }
}
