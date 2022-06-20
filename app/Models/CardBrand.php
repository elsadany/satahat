<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardBrand extends Model {

    use HasFactory;

    protected $table = 'card_brands';
    protected $guarded = ['id'];

    protected $hidden=['image'];
    protected $appends = ['imagePath','name'];

    function getImagePathAttribute() {
        if ($this->image != '') {
            if (strpos($this->image, "http") !== false)
                return $this->image;
            else if (strstr($this->image, 'uploads'))
                return url($this->image);
        }
    }
      function getNameattribute(){
        if(session('language_symbol')=='en')
            return $this->name_en;
        return $this->name_ar;
    }
     

}
