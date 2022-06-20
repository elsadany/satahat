<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersFiles extends Model {
protected $table='orders_files';
    use HasFactory;
     protected $appends=['filePath'];
        function getFilePathAttribute() {
        if ($this->file != '') {
            if (strpos($this->file, "http") !== false)
                return $this->file;
            else if (strstr($this->file,'uploads'))
                return url($this->file);
            
        }
        return 'https://www.w3schools.com/howto/img_avatar.png';
    }


}
