<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionPrintController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/transactions/{transaction}/print', TransactionPrintController::class)->name('transactions.print');
