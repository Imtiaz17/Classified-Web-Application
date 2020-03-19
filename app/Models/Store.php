<?php


namespace App\Models;

use App\Models\Scopes\ActiveScope;

class Store extends BaseModel
{
	protected $table = 'stores';

	protected $guarded = [];

	public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function schedule()
    {
        return $this->hasMany(StoreSchedule::class, 'store_id');
    }
    
}

