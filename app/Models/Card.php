<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model {

    use HasFactory;
    protected $casts = [
        'expiry_date'  => 'date:Y-m',
        // 'updated_at' => 'datetime:Y-m-d H:00',
    ];
    protected $table = 'cards';
    protected $guarded = ['id'];
protected $with=['brand'];


   public function brand()
   {return $this->belongsTo(CardBrand::class,'card_brand_id');
   }
     

}
