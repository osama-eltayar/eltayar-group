<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionPrintController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Transaction $transaction)
    {
        return view('transactions.print', compact('transaction'));
    }
}
