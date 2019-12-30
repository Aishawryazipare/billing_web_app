<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillMaster extends Model
{
    protected $primaryKey = "bill_no";
    public $table = "bil_AddBillMaster";
    public $timestamps=false;
    protected $fillable = [
        'bill_code','bill_date','order_type','table_no','waiter','app_bill_id','cust_id','cust_name','cash_or_credit','point_of_contact','discount','gst_setting','bill_totalamt','bill_tax','payment_details','order_details','created_at_TIMESTAMP','updated_at_TIMESTAMP','isactive','lid','cid','emp_id'
    ];
}
