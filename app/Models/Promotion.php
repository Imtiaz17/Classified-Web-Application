<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;

class Promotion extends BaseModel
{
    protected $table = 'promotions';

    protected $guarded = ['id'];
}
