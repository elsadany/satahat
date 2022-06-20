<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompaniesHarbor extends Model {

    use HasFactory;

   
    protected $guarded = ['id'];
    public $timestamps = false;
   
   public function saudiharbour()
   {
       return $this->belongsTo(SaudiHarbor::class,'saudi_harbor');
   }
   public function chinaharbour()
   {
       return $this->belongsTo(SaudiHarbor::class,'china_harbor');
   }
      function company(){
          return $this->belongsTo(Company::class,'company_id');
      }

}
