<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\TransactionPrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/transactions/{transaction}/print', TransactionPrintController::class)->name('transactions.print');

Route::get('/invitation/{token}', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/invitation/{token}', [InvitationController::class, 'store'])->name('invitation.store');
