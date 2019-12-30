<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $primaryKey = "table_id";
    public $table = "bil_add_table";
    public $timestamps=true;
    protected $fillable = [
        'table_no','capacity','cid','lid','emp_id','is_active'
    ];
}
