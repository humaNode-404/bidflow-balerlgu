<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrController;
use App\Http\Controllers\StageActionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Office;
use App\Models\User;
use App\Events\NotificationSent;
use App\Http\Controllers\PrCreationController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

  Route::controller(PrCreationController::class)->group(function () {
    Route::post('/dashboard/step1', 'step1')->name('pr.create.step1');
    Route::post('/dashboard/step2', 'step2')->name('pr.create.step2');
    Route::post('/dashboard/step3', 'step3')->name('pr.create.step3');
    Route::post('/dashboard/step4', 'step4')->name('pr.create.step4');
    Route::post('/dashboard/step5', 'step5')->name('pr.create.step5');
  });

  Route::redirect('/', '/dashboard');

  Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'show')->name('dashboard');
  });

  Route::controller(ArchiveController::class)->group(function () {
    Route::get('/archive', 'show')->name('archive');
  });

  Route::controller(StageActionController::class)->group(function () {
    Route::get('/pr/{prdoc:number}/{stageaction:uuid}', 'show')->name('stage.show');
    Route::post('/stageaction/{stageaction:uuid}/submit', 'submit')->name('stage.submit');
    Route::post('/stageaction/{stageaction:uuid}/received', 'received')->name('stage.received');
    Route::post('/stageaction/{stageaction:uuid}/proceed', 'proceed')->name('stage.proceed');
  });

  Route::controller(PrController::class)->group(function () {
    Route::get('/pr/{uuid}', 'show')->name('pr');
    Route::post('/pr/{prdoc:uuid}/delete', 'delete')->name('pr.delete');
  });

  Route::controller(AccountController::class)->group(function () {
    Route::get('/account', 'show')->name('account.show');
    Route::post('/account/updateInfo', 'updateInfo')->name('updateInfo');
    Route::post('/account/updatePassword', 'updatePassword')->name('updatePassword');
  });

  Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'show')->name('users.show');
    Route::post('/users/create', 'create')->name('users.create');
    Route::post('/users/update', 'update')->name('users.update');
    Route::post('/users/delete', 'delete')->name('users.delete');
  });
});
