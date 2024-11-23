<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return Inertia::render('dashboard');
});

Route::get('{any?}', function () {
    return Inertia::render('error');
})->where('any', '.*');
