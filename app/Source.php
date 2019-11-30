<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $primaryKey = "id";
    public $table = "tbl_source";
    public $timestamps=false;
    protected $fillable = [
        'name'
    ];
}
