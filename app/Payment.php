<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'driver_id', 'amount', 'luggage'];


    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function driver() {
    	return $this->belongsTo(Driver::class, 'driver_id');
    }

    /**
     * Get the total attribute
     *
     * @return string
     */
    public function getTotalAttribute() {
        return $this->amount + $this->luggage;
    }



}
