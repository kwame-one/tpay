<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'vehicle_model', 'vehicle_number', 'balance'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function paymets() {
    	return $this->hasMany(Payment::class, 'driver_id');
    }
}
