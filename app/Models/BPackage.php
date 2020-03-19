<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BPackage extends BaseModel
{
    protected $guarded = [];



    public function payments()
    {
        return $this->hasMany(Payment::class, 'package_id');
    }

     public function durations()
    {
        return $this->hasMany(Duration::class, 'package_id');
    }
}
