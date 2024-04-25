<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminAccessMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware(['auth'])->group(function () {
  // 決済
  Route::get('/purchase', [PurchaseController::class, 'index']);
  Route::post('/process-payment', [PurchaseController::class, 'processPayment']);

  // サブスクリプション
  Route::get('/subscription', [SubscriptionController::class, 'index']);
  Route::post('/user/subscribe', function (Request $request) {
    $user = $request->user();
    $subscription = $user->newSubscription('default', 'price_1P8EZXCq7haun9AiRBDr1sM8')
      ->create($request->paymentMethodId);
    return to_route('dashboard');
  });
});


Route::post('/contact', [ContactController::class, 'store']);

Route::middleware(['auth', 'admin_master_access'])->group(function () {
  Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
  Route::post('/event', [EventController::class, 'store'])->name('event.store');
  Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
  Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update');
  Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('event.destroy');
});
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{event}/show', [EventController::class, 'show'])->name('event.show');

Route::resource('application', ApplicationController::class)->middleware(['auth']);

Route::middleware(['admin_master_access'])->group(function () {
  Route::resource('admin', ApplicationController::class);
});

Route::put('/user/{user}', [UserController::class, 'update'])
  ->middleware(['auth'])->name('user.update');

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
