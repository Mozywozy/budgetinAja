<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Budget\Index as BudgetIndex;
use App\Livewire\Category\Index as CategoryIndex;
use App\Livewire\Transaction\Index as TransactionIndex;
use App\Livewire\Goal\Index as GoalIndex;
use App\Livewire\Profile;
use App\Livewire\Notification\Index as NotificationIndex;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/budgets', BudgetIndex::class)->name('budgets');

    Route::get('/categories', CategoryIndex::class)->name('categories');

    Route::get('/transactions', TransactionIndex::class)->name('transactions');

    Route::get('/goals', GoalIndex::class)->name('goals');

    Route::get('/profile', Profile::class)->name('profile');

    Route::get('/notifications', NotificationIndex::class)->name('notifications');
});

Route::post('/send-suggestion', [\App\Http\Controllers\SuggestionController::class, 'send'])->name('send.suggestion');
