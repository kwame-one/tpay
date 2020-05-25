<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserWalletResource;
use App\Wallet;
use App\UserWallet;
use App\Http\Resources\TransactionResource;
use App\Payment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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


    /**
     * Accept payment
     *
     * @param Request $r
     * @return Object
     */

	public function acceptPayment(Request $r) {
		$validate = Validator::make($r->all(), [
			'wallet_id' => 'required|integer,exits:user_wallets',
			'amount' => 'required|numeric'
		]);

		if($validate->fails())
			return $this->validateError($validate->getMessageBag()->first());

        $user_wallet = UserWallet::where('wallet_id', $r->wallet_id)->first();

        if(!$user_wallet) {
            return $this->results(['message' => 'wallet not found', 'data' => null], 404);
        }

        if($user_wallet->status == 0) {
            return $this->results(['message' => 'wallet deactivated', 'data' => null], 403);
        }

        if($user_wallet->balance < $r->amount) {
            return $this->results(['message' => 'balance not enough', 'data' => null], Response::HTTP_PAYMENT_REQUIRED);
        }

        $user_wallet->update([
            'balance' => $user_wallet->balance - $r->amount
        ]);

        Auth::user()->driver->increment('balance', $r->amount);

        Payment::create([
            'user_id' => $user_wallet->user_id,
            'driver_id' => Auth::user()->driver->id,
            'amount' => $r->amount,
        ]);

        return $this->results(['message' => 'payment successful', 'data' => null]);


    }

    /**
     * View expenses
     *
     * @param Request $r
     * @return Object
     */
    public function getExpenses(Request $r) {
        if($r->has('month') && !empty($r->month)) {

        }

        $expenses = Payment::all();
    }


}
