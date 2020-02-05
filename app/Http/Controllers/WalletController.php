<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use QrCode;
use App\UserWallet;

class WalletController extends Controller
{
    

    public function index() {
        $wallets = Wallet::orderBy('created_at', 'desc')->get();
    	return view('wallets.index', compact('wallets'));
    }

    public function userWallets() {
        $userWallets = UserWallet::all();
        return view('wallets.user_wallets', compact('userWallets'));
    }


    public function showGenerateWalletForm() {
    	return view('wallets.generate');
    }

    public function generateWallets(Request $request) {
    	$request->validate([
    		'number' => 'required|numeric'
    	]);


    	$last = Wallet::orderBy('id', 'desc')->first();
    	$count = 1;

    	if($last){
    		$count = $last->id;
    		$count++;
    	}

    	for ($i=0; $i<$request->number ; $i++) { 
    		$name = uniqid().".png";
    		QrCode::format('png')->size(400)->generate("$count", '../public/img/wallets/'.$name);
    		Wallet::create(['name' => $name]);
    		$count++;
    	}

    	return back()->with('success', 'wallets generated successfully');

    }

    public function delete(Request $request) {
        $wallet = Wallet::find($request->id);

        if(!$wallet)
            return back()->with('error', 'wallet not found');

        $wallet->delete();

        return back()->with('success', 'wallet deleted successfully');
    }
}
