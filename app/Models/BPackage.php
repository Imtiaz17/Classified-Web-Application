<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bpackage extends BaseModel
{
    protected $guarded = [];

    protected $table = 'b_packages';


    public function payments()
    {
        return $this->hasMany(Payment::class, 'package_id');
    }

     public function durations()
    {
        return $this->hasMany(Duration::class, 'package_id');
    }
}
