<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Wallet;
use App\UserWallet;
use App\Transaction;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $users = User::where('role_id', 3)->count();
        $drivers = User::where('role_id', 2)->count();
        $wallets = Wallet::count();
        $takenWallets = Wallet::where('taken', 1)->count();
        $unUsedWallets = $wallets - $takenWallets;
        $activatedWallets = UserWallet::where('status', 1)->count();
        $deactivatedWallets = UserWallet::where('status', 0)->count();
        $deposits = Transaction::where('type', 'deposit')->count();
        $withdrawals = Transaction::where('type', 'withdrawal')->count();

        return view('home', compact('users', 'drivers', 'wallets', 'takenWallets', 'activatedWallets', 'deactivatedWallets', 'deposits', 'withdrawals', 'unUsedWallets'));
    }
}
