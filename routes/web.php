<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

  Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
  })->name('dashboard');

  Route::get('/settings', function () {
    return Inertia::render('Settings', [
      "filters" => request()->only(['tab']),
    ]);
  })->name('settings');


  Route::get('/users', function () {
    return Inertia::render('Users', [
      "users" => User::all()->map(fn($user) => [
        "id" => $user->id,
        "name" => $user->name,
        "email" => $user->email,
        "date" => $user->created_at,
        "role" => $user->role,
      ])
    ]);
  })->name('users');

});

