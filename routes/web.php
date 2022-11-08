<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::get('dashboard', [TestController::class, 'dashboard']); 
Route::get('login', [TestController::class, 'index'])->name('login');
Route::post('custom-login', [TestController::class, 'customLogin'])->name('logins'); 
Route::get('registration', [TestController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [TestController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [TestController::class, 'signOut'])->name('signout');
//addPay
Route::post('addPaymentMethod', [TestController::class, 'addPayment'])->name('addPays');

//checkm
Route::get('checkPaymentMethod', [TestController::class, 'checkm'])->name('checkPays');
//