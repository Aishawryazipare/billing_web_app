<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    protected $primaryKey = "id";
    public $table = "bil_add_waiter";
    public $timestamps=true;
    protected $fillable = [
        'waiter_name','is_active','cid','lid','emp_id'
    ];
}
