<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Events\NotificationSent;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Office;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

  Route::redirect('/', '/dashboard');

  Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'show')->name('dashboard');
  });

  Route::controller(PrController::class)->group(function () {
    Route::get('/pr/{uuid}', 'show')->name('pr');
  });



  Route::get('/account', function () {
    return Inertia::render('Account', [
      "filters" => request()->only(['tab']),
      "Office" => Office::select('id', 'name', 'abbr')->distinct()->get(),
    ]);
  })->name('settings');

  Route::get('/calendar', function () {
    return Inertia::render('Calendar', [

    ]);
  })->name('calendar');


  // Route::get('/send-test-email', function () {
  //   Mail::to('rymemarzan.stud.ofclacc1@gmail.com')->send(new TestMail());
  //   return 'Test email sent!';
  // });

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

