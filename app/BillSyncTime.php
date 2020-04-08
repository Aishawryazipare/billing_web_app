<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillSyncTime extends Model
{
    protected $primaryKey = "id";
    public $table = "bil_sync_time";
    public $timestamps = false;
    protected $fillable = [
        'cid', 'lid', 'emp_id', 'upload_interval', 'download_interval', 'sync_flag'
    ];
}

