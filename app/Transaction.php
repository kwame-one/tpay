<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'code', 'total', 'user_id', 'status'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
