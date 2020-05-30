<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'code', 'total', 'user_id', 'status', 'phone'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusAttribute($value) {
        $status = "pending";
        if($value == 1)
            $status = "success";
        else if ($value == 2)
            $status = "failure";

        return $status;

    }
}
