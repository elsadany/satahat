<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    use HasFactory;

    protected $table = 'orders';
    protected $guarded = ['id'];
protected $casts = [
    'created_at'  => 'date:m-d- H:00',
    // 'updated_at' => 'datetime:Y-m-d H:00',
];
    protected $appends=['mainSpecialist','secondarySpecialist'];
    protected $with = ['user','delivery','offers','rates'];


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
     function rates(){
        return $this->hasMany(Rate::class,'order_id')->orderBy('id','desc');
    }
}
