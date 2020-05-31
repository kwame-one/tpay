<?php

namespace App\Http\Controllers\Api;

use App\Wallet;
use App\UserWallet;
use App\Payment;
use App\Traits\Utils;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Http\Resources\DriverResource;
use Illuminate\Http\Request;
use App\Http\Resources\UserWalletResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Transaction;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiController extends Controller
{
    use Utils;

    public function updateFcmToken(Request $r) {
        $validate = Validator::make($r->all(), [
            'token' => 'required|'
        ]);

        if($validate->fails())
         return $this->validateError($validate->getMessageBag()->first());

        auth()->user()->update(['fcm_token' => $r->token]);

        return $this->results(['message' => 'token updated', 'data' => null]);
    }

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
			'wallet_id' => 'required|integer|exists:user_wallets',
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
     * Update user details
     *
     * @param Request $request
     * @return Object
     */
    public function updateUserDetails(Request $request) {
        $validate = Validator::make($request->all(), [
            'other_names' => 'required|string',
            'surname' => 'required|string',
            'vehicle_number' => ['nullable', Rule::requiredIf(auth()->user()->isDriver())],
            'vehicle_model' => ['nullable', Rule::requiredIf(auth()->user()->isDriver())]
        ]);

        if($validate->fails())
            return $this->validateError($validate->getMessageBag()->first());

        $user = Auth::user();

        $user->update([
            'other_names' => $request->other_names,
            'surname' => $request->surname,
        ]);

        if($user->isDriver()) {
            $user->driver->update([
                'vehicle_model' => $request->vehicle_model,
                'vehicle_number' => $request->vehicle_number
            ]);
        }


        return $this->results(['message' => 'details updated', 'data' => new UserResource($user->fresh())]);

    }


    /**
     * Get Driver's account Balance
     *
     * @return Object
     */
    public function getDriverAccountBalance() {
        $driver = Auth::user()->driver;

        return $this->results(['message' => 'account balance', 'data' => new DriverResource($driver)]);
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


    /**
     * Credit digital wallet
     *
     * @param Request $request
     * @return Object
     */
    public function creditWallet(Request $request) {
        $validate = Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'token' => ['nullable', Rule::requiredIf(function() {
                $phone = substr(request('phone'), 0, 3);
                return $phone === "050" || $phone == "020";
            })]
        ]);

        if($validate->fails())
            return $this->validateError($validate->getMessageBag()->first());


        $status = $this->payViaMomo(
            $request['phone'],
            $request['amount']
        );


        if(!$status)
            return $this->results([
                'message' => 'payment not initialized initialized',
                'data' => null], Response::HTTP_BAD_REQUEST);

        return $this->results(['message' => 'payment initialized', 'data' => null]);
    }

    /**
     * Withdraw revenue
     *
     * @param Request $request
     * @return Object
     */
    public function withdraw(Request $request) {

        $validate = Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'phone' => ['required', 'regex:/^[0-9]{10}$/'],
        ]);

        if($validate->fails())
            return $this->validateError($validate->getMessageBag()->first());


        if(auth()->user()->driver->balance < $request['amount']) {
            return $this->results([
                'message' => 'not enough balance',
                'data' => null,
            ], Response::HTTP_PAYMENT_REQUIRED);
        }


        $status = $this->withdrawViaMomo(
            $request['phone'],
            $request['amount']
        );

        if(!$status)
            return $this->results([
                'message' => 'transfer not initialized initialized',
                'data' => null], Response::HTTP_BAD_REQUEST);

        return $this->results(['message' => 'transfer initialized', 'data' => null]);
    }


    /**
     * Payment callback
     *
     * @param Request $request
     * @return void
     */
    public function callback(Request $request) {
        $transaction = Transaction::where('code', $request['txRef'])->first();

        if(!$transaction)
            return;

        if(strtolower($transaction->status) == "success")
            return;

        if(strtolower($request['status']) === "successful") {
            $transaction->update(['status'=> 1]);

            if(strtolower( $transaction->type == "deposit")) {
                $transaction->user->userWallet->increment('balance', $transaction->total);
            }else {
                $transaction->user->driver->decrement('balance', $transaction->total);
            }

            $this->notifyUser(
                "TPAY",
                "Your wallet has been successfully credited with GHS $transaction->total",
                $transaction->user->fcm_token);
        }else {
            $transaction->update(['status'=> 2]);

            $this->notifyUser(
                "TPAY",
                "Wallet could not be credited   ",
                $transaction->user->fcm_token
            );
        }
    }



}
