<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('user.{id}', function ($id) {
    return Auth::user()->id === $id;
});
