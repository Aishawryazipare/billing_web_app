<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempDetail extends Model
{
    public $table = "bil_temp_detail";
    public $timestamps=false;
    protected $fillable = [
        'bill_no','table_no','item_name','item_qty','item_rate','discount','bill_tax','item_totalrate','created_at_TIMESTAMP','updated_at_TIMESTAMP','kot_print','isactive','lid','cid','emp_id'
    ];
}
