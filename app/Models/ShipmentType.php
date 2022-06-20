<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentType extends Model {

    use HasFactory;

    protected $table = 'shipment_types';
    protected $guarded = ['id'];
    public $timestamps = false;
     protected $appends = ['name'];

    function getNameAttribute(){
        if(session('language_symbol')=='en')
            return $this->name_en;
        return $this->name_ar;
    }
     
}
