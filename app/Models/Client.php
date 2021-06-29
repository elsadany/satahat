<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table='clients';
   protected $primaryKey='user_id';
   protected $appends=['job'];
   
    public $timestamps=false;

    function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    function getJobAttribute(){
        $job= Job::find($this->job_id);
        if(is_object($job))
            return $job->name;
        return '';
    }
   
}
