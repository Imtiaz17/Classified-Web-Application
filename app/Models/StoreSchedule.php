<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSchedule extends BaseModel
{
    protected $table = 'store_schedule';

    protected $guarded = [];
    
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
