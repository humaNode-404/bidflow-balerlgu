<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PrController;
use App\Http\Controllers\PrdocController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StageActionController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

  Route::redirect('/', '/dashboard');

  Route::resource('prdocs', PrdocController::class)->parameters([
    'prdocs' => 'prdoc:number',
  ]);


  Route::resource('notif', NotificationController::class);
  Route::post('notif/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notif.markAllAsRead');
  Route::post('notif/delete-all', [NotificationController::class, 'deleteAll'])->name('notif.deleteAll');

  Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'show')->name('dashboard');
  });

  Route::controller(ArchiveController::class)->group(function () {
    Route::get('/archive', 'show')->name('archive');
  });

  Route::controller(StageActionController::class)->group(function () {
    Route::get('/pr/{prdoc:number}/{stageaction:uuid}', 'show')->name('stage');
    Route::post('/stageaction/{stageaction:uuid}/submit', 'submit')->name('stage.submit');
    Route::post('/stageaction/{stageaction:uuid}/received', 'received')->name('stage.received');
    Route::post('/stageaction/{stageaction:uuid}/proceed', 'proceed')->name('stage.proceed');
  });

  Route::controller(PrController::class)->group(function () {
    Route::get('/pr/{number}', 'show')->name('pr');
    Route::post('/pr/{prdoc:number}/delete', 'delete')->name('pr.delete');
  });

  Route::controller(AccountController::class)->group(function () {
    Route::get('/account', 'show')->name('account');
    Route::post('/account/updateInfo', 'updateInfo')->name('updateInfo');
    Route::post('/account/updatePassword', 'updatePassword')->name('updatePassword');
  });

  Route::middleware(['role:admin'])->group(function () {
    Route::prefix('settings')->group(function () {
      Route::resource('offices', OfficeController::class);

      Route::resource('users', UserController::class);

      Route::prefix('backup')->group(function () {
        Route::controller(BackupController::class)->group(function () {
          Route::get('', 'list')->name('backup');
          Route::post('/run', 'run')->middleware('throttle:backup-run')->name('backup.run');
          Route::post('/clean', 'clean')->name('backup.clean');
          Route::post('/download/{file}', 'download')->name('backup.download');
        });
      });
    });
  });

});
