<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications', function ($user) {
    return true; // You may want to restrict this to authenticated users
});
