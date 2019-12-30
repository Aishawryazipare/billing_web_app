<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempMaster extends Model
{
    protected $primaryKey = "tbl_bill_no";
    public $table = "bil_temp_master";
    public $timestamps=false;
    protected $fillable = [
        'bill_date','table_no','waiter','cust_id','cust_name','cash_or_credit','point_of_contact','discount','gst_setting','bill_totalamt','bill_tax','payment_details','order_details','isactive','lid','cid','emp_id'
    ];
}
