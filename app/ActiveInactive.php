<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveInactive extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = "id";
    public $table = "tbl_active_inactive";
    public $timestamps=false;
     protected $fillable = [
        'status','is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
   
}
