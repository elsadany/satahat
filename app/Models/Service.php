<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {

    use HasFactory;

    protected $table = 'services';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden=['image'];
    protected $appends = ['imagePath','title','description'];

    function getImagePathAttribute() {
        if ($this->image != '') {
            if (strpos($this->image, "http") !== false)
                return $this->image;
            else if (strstr($this->image, 'uploads'))
                return url($this->image);
        }
    }
      function getTitleattribute(){
        if(session('language_symbol')=='en')
            return $this->title_en;
        return $this->title_ar;
    }
      function getDescriptionAttribute(){
        if(session('language_symbol')=='en')
            return $this->description_en;
        return $this->description_ar;
    }

}
