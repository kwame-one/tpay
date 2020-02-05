<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWallet extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'wallet_id', 'status', 'balance'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }


    public function wallet() {
    	return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}
