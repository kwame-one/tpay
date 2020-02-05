<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    
    public function index() {
    	return view('admin.index');
    }

    public function showNewAdminForm() {
    	return view('admin.add');
    }

    public function account() {
    	return view('admin.account');
    }
}
