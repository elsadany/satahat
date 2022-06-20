<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasApiTokens,HasFactory;
    protected $guarded=['password','id'];
  protected $appends=['sections','imagePath'];
    protected $hidden=['password','parent','created_at','updated_at','mail_confirmed',
        'reset_password_token','remember_token','image'];
   
            function getImagePathAttribute() {
        if ($this->image != '') {
            if (strpos($this->image, "http") !== false)
                return $this->image;
            else if (strstr($this->image,'uploads'))
                return url($this->image);
            
        }
        return 'https://www.w3schools.com/howto/img_avatar.png';
    }
    function getSectionsAttribute(){
        return AdminSections::where('admin_id',$this->id)->pluck('section')->toArray();
    }
 
 
    
}
