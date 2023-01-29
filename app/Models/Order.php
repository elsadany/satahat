<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    use HasFactory;

    protected $table = 'orders';
    protected $guarded = ['id'];
protected $casts = [
    'created_at'  => 'date:m-d- H:00',
    // 'updated_at' => 'datetime:Y-m-d H:00',
];
  protected $appends=['remain','invoicefile','listfile'];
    protected $with = ['user','company','chinaharbor','saudiharbor','shippingType','files'];


     function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }
  
    function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
  function getRemainAttribute(){
      $payed=OrdersTransaction::where('order_id',$this->id)->sum('payed');
      return $this->price-$payed;
  }
  function getInvoicefileAttribute(){
      if($this->invoice!='')
      return url($this->invoice);
      return 'http://www.africau.edu/images/default/sample.pdf';
  }
  function getListfileAttribute(){
      if($this->list!='')
      return url($this->list);
      return 'http://www.africau.edu/images/default/sample.pdf';
  }
  function chinaharbor(){
      return $this->belongsTo(ChinaHarbor::class,'china_harbor_id');
  }
  function saudiharbor(){
      return $this->belongsTo(SaudiHarbor::class,'saudi_harbor_id');
  }
  function shippingType(){
      return $this->belongsTo(ShipmentType::class,'shipment_type_id');
  }
  function files(){
      return $this->hasMany(OrdersFiles::class,'order_id');
  }
}
