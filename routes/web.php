<?php

use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return Inertia::render('dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('dashboard');
});

Route::get('/users', function () {
    return Inertia::render('users', [
        'users' => User::query()
            ->when(request()->input('search'), function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%");
            })
            ->get() // Corrected from all() to get()
            ->map(fn($user) => [
                'id' => $user->id,
                'name' => ucwords($user->first_name . ' ' . $user->last_name),
                'email' => $user->email,
                'date' => (string) (new DateTime($user->created_at))->format('d F, Y \a\t h:i A'),
                'role' => $user->role,
            ]),

        //'filters' => Request::only(['search'])
    ]);
});

Route::get('/settings', function () {
    return Inertia::render('settings');
});

Route::get('/cards', function () {
    return Inertia::render('cards');
});

Route::get('/form-layouts', function () {
    return Inertia::render('form-layouts');
});

Route::get('/icons', function () {
    return Inertia::render('icons');
});

Route::get('/login', function () {
    return Inertia::render('login');
});

Route::get('/register', function () {
    return Inertia::render('register');
});

Route::get('/tables', function () {
    return Inertia::render('tables');
});

Route::get('/typography', function () {
    return Inertia::render('typography');
});

Route::get('{any?}', function () {
    return Inertia::render('error');
})->where('any', '.*');
