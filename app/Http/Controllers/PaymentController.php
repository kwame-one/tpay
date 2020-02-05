<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Transaction;

class PaymentController extends Controller
{
    

    public function getPayments() {
    	$payments = Payment::orderBy('created_at', 'desc')->get();
    	return view('transactions.payments', compact('payments'));
    }


    public function getTransactions() {
    	$transactions = Transaction::orderBy('created_at', 'desc')->get();
    	return view('transactions.transactions', compact('transactions'));
    }
}
