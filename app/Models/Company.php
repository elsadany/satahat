<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {

    use HasFactory;

    protected $table = 'companies';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden=['image'];
    protected $appends = ['imagePath','name','description'];

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
      function getDescriptionAttribute(){
        if(session('language_symbol')=='en')
            return $this->description_en;
        return $this->description_ar;
    }
    function harbors(){
        return $this->hasMany(CompaniesHarbor::class,'company_id');
    }

}
