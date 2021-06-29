<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model {

    use HasFactory;

  
    public $timestamps = false;

    protected $with=['delivery'];
    function delivery(){
        return $this->belongsTo(User::class,'delivery_id');
    }

}
