<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;

class AdminController extends Controller
{
    
    public function index() {
    	$admins = User::where('role_id', 1)->get();
    	return view('admin.index', compact('admins'));
    }

    public function showNewAdminForm() {
    	return view('admin.add');
    }

    public function account() {
    	return view('admin.account');
    }

    public function store(Request $request) {
    	$request->validate([
    		'surname' => 'required',
    		'other_names' => 'required',
    		'email' => 'required|email',
    		'contact' => 'required'
    	]);

    	$user = User::create([
    		'surname' => $request->surname,
    		'other_names' => $request->other_names,
    		'email' => $request->email,
    		'contact' => $request->contact,
    		'role_id' => 1,
    		'password' => Hash::make('email')
    	]);

    	if(!$user)
    		return back()->with('error', 'error adding admin');

    	return back()->with('success', 'admin added successfully');
    }

    public function changePassword(Request $request) {
    	$request->validate([
    		'old' => 'required',
    		'password' => 'required',
    		'password_confirmation' => 'required'
    	]);

    	$admin = Auth::user();

    	if(!Auth::check($request->password, $admin->password)) 
    		return back()->with('invalid', 'incorrect password');

    	$admin->update(['password' => Hash::make($request->password)]);

    	if($admin)
    		return back()->with('success', 'password updated');

    	return back()->with('error', 'error changing password');
    }
}
