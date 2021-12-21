<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondarySpecialist extends Model {

    use HasFactory;

    protected $table = 'secondary_specialists';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with=['mainspecialist'];
   protected $appends = ['name','imagePath'];
   protected $hidden=['main_specialist_id','image'];
           function getImagePathAttribute() {
        if ($this->image != '') {
            if (strpos($this->image, "http") !== false)
                return $this->image;
            else if (strstr($this->image, 'uploads'))
                return url($this->image);
        }
    }
    function getNameAttribute(){
        if(session('language_symbol')=='en')
            return $this->name_en;
        return $this->name_ar;
    }
    function mainspecialist(){
        return $this->belongsTo(MainSpecialist::class,'main_specialist_id');
    }

}
