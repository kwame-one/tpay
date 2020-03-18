<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserWalletResource;
use Auth;
use Validator;
use App\Wallet;
use App\UserWallet;
use App\Http\Resources\TransactionResource;

class ApiController extends Controller
{
    
	//get user wallet
    public function myWallet() {
	 	$user = Auth::user();
	 	return $this->results(['message' => 'user wallet', 'data' => new UserWalletResource($user->wallet)]);
    }


   	public function setupWallet(Request $request) {
   		$validate = Validator::make($request->all(), [
   			'wallet' => 'required|numeric'
   		]);

   		if($validate->fails())
    		return $this->validateError($validate->getMessageBag()->first());

    	$wallet = Wallet::find($request->wallet);

    	if(!$wallet)
    		return $this->results(['message' => 'wallet not found', 'data' => null], 404);

    	if($wallet->taken == 1)
			return $this->results(['message' => 'wallet taken', 'data' => null]);
		

		$userWallet = UserWallet::create([
			'user_id' => Auth::user()->id,
			'wallet_id' => $wallet->id,
			'status' => 1
		]);

		$wallet->update(['taken' => 1]);

    	return $this->results(['message' => 'wallet activated', 'data' => new UserWalletResource($userWallet)]);
	}
	   

	public function activateWallet() {
		$wallet = Auth::user()->userWallet;

		if(!$wallet)
			return $this->results(['message' => 'you do not have any wallet', 'data' => null]);

		$wallet->update(['status' => 1]);

		return $this->results(['message' => 'wallet activated', 'data' => null]);
	}

   	public function deactivateWallet() {
   		$wallet = Auth::user()->userWallet;

   		if(!$wallet)
   			return $this->results(['message' => 'you do not have a wallet', 'data' => null], 404);

   		$wallet->update(['status' => 0]);

   		return $this->results(['message' => 'wallet deactivated', 'data' => null]);


	}
	
	public function checkWalletBalance() {
		$wallet = Auth::user()->userWallet;

		if(!$wallet)
			return $this->results(['message' => 'wallet not found', 'data' => null], 404);
		
		return $this->results(['message' => 'balance', 'data' => new UserWalletResource($wallet)]);

	}


   	public function getTransactions() {
   		$transactions = Auth::user()->transactions()->orderBy('created_at', 'desc')->get();
   		return $this->results(['message' => 'transactions', 'data' => TransactionResource::collection($transactions)]);

   	}

   	


}
