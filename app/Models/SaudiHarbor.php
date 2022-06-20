<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaudiHarbor extends Model {

    use HasFactory;

   
    protected $guarded = ['id'];
    public $timestamps = false;
   
    protected $appends = ['name'];

 
      function getNameattribute(){
        if(session('language_symbol')=='en')
            return $this->name_en;
        return $this->name_ar;
    }
      

}
