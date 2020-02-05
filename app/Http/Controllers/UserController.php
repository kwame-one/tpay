<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getNormalUsers() {
    	$users = User::where('role_id', 3)->orderBy('created_at', 'desc')->get();
    	return view('users.users', compact('users'));
    }

    public function getDrivers() {
    	$drivers = User::where('role_id', 2)->orderBy('created_at', 'desc')->get();
    	return view('users.drivers', compact('drivers'));
    }
}
