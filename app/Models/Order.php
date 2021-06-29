<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    use HasFactory;

    protected $table = 'orders';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $appends=['mainSpecialist','secondarySpecialist'];
    protected $with = ['user','delivery','offers'];


     function delivery() {
        return $this->belongsTo(User::class, 'delivery_id');
    }
  
    function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
   
    function getMainSpecialistAttribute(){
        $specialist= MainSpecialist::find($this->main_specialist_id);
        if(is_object($specialist))
            return $specialist->name;
        return '';
    }
    function getSecondarySpecialistAttribute(){
        $specialist= SecondarySpecialist::find($this->secondary_specialist_id);
        if(is_object($specialist))
            return $specialist->name;
        return '';
    }
    function offers(){
        return $this->hasMany(Offer::class,'order_id');
    }
}
