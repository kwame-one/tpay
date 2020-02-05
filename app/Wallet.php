<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'taken'];

    public function getNameAttribute($value) {
    	return asset("img/wallets/".$value);
    }
}
