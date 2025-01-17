<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AuthResource;
use App\Http\Resources\DriverResource;


class AuthController extends Controller
{


    public function register(Request $request) {
    	$validate = Validator::make($request->all(), [
    		'surname' => 'required|string',
    		'other_names' => 'required|string',
    		'contact' => 'required|numeric|unique:users,contact',
   			'password' => 'required',
            'role' => 'required'
    	]);

    	if($validate->fails())
    		return $this->validateError($validate->getMessageBag()->first());

    	$user = User::create([
    		'surname' => $request->surname,
    		'other_names' => $request->other_names,
    		'contact' => $request->contact,
    		'password' => Hash::make($request->password),
    		'role_id' => $request->role
		]);

		$user->token = $user->createToken('auth token')->accessToken;

    	return $this->results(['message' => 'registration successful', 'data' => new AuthResource($user)]);

    }


    public function login(Request $request) {
    	$validate = Validator::make($request->all(), [
    		'contact' => 'required|numeric',
    		'password' => 'required',
    	]);

    	if($validate->fails())
    		return $this->validateError($validate->getMessageBag()->first());

    	$user = User::where('contact', $request->contact)->first();

    	if($user && Hash::check($request['password'], $user->password) && $user->role_id != 1) {
			$user->token = $user->createToken('auth token')->accessToken;

			if($user->role_id == 2 && $user->driver == null)
				return $this->results(['message' => 'driver not setup', 'data' => new AuthResource($user)]);

			if($user->role_id == 3 && $user->userWallet == null)
				return $this->results(['message' => 'wallet not set up', 'data' => new AuthResource($user)]);

    		return $this->results(['message' => 'login successful', 'data' => new AuthResource($user)]);
    	}else
    		return $this->results([ 'message' => 'invalid credentials', 'data' => null], 401);


    }


    public function saveDriverDetails(Request $request) {
        $validate = Validator::make($request->all(), [
            'vehicle_model' => 'required',
            'vehicle_number' => 'required'
        ]);

        if($validate->fails())
            return $this->validateError($validate->getMessageBag()->first());

		if(Auth::user()->role_id != 2)
			return $this->results(['message' => 'sorry, you are not a driver', 'data' => null], 404);

		if(Auth::user()->driver)
			return $this->results(['message' => 'sorry details already saved', 'data' => new DriverResource(Auth::user()->driver)]);

		$driver = Driver::create([
            'user_id' => Auth::user()->id,
            'vehicle_number' => $request->vehicle_number,
            'vehicle_model' => $request->vehicle_model
        ]);

        if($driver)
            return $this->results(['message' => 'driver details saved', 'data' => new DriverResource($driver)]);

	}

	public function changePassword(Request $request) {
		$validate = Validator::make($request->all(), [
			'old_password' => 'required',
			'password' => 'required|confirmed',
		]);

		if($validate->fails())
			return $this->validateError($validate->getMessageBag()->first());

		$user = Auth::user();

		if(!Hash::check($request->old_password, $user->password))
			return $this->results(['message' => 'invalid password', 'data' => null], 401);

		$user->update(['password' => Hash::make($request->password)]);

		return $this->results(['message'=> 'password changed successfully', 'data' => null]);
	}

}
