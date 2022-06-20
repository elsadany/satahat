<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model {

    use HasFactory;

    protected $table = 'testimonials';
    protected $guarded = ['id'];
    public $timestamps = false;
   
    protected $appends = ['name','description'];

 
      function getNameattribute(){
        if(session('language_symbol')=='en')
            return $this->name_en;
        return $this->name_ar;
    }
      function getDescriptionAttribute(){
        if(session('language_symbol')=='en')
            return $this->description_en;
        return $this->description_ar;
    }

}
