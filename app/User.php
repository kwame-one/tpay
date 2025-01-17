<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surname', 'other_names', 'contact', 'email', 'password', 'role_id', 'verification_code', 'verified',
        'fcm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userWallet() {
        return $this->hasOne(UserWallet::class, 'user_id');
    }

    public function driver() {
        return $this->hasOne(Driver::class, 'user_id');
    }

    public function paymets() {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function isDriver(){
        return $this->role_id == 2;
    }

    public function isNormalUser() {
        return $this->role_id == 3;
    }
}
