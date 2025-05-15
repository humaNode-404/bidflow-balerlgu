<?php

namespace App\Observers;

use App\Events\ProfileUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use App\Models\user;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class UserObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the user "created" event.
     */
    public function created(user $user): void
    {
        //
    }

    /**
     * Handle the user "updated" event.
     */
    public function updated(user $user): void
    {
        Event::dispatch(new ProfileUpdated($user));
    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(user $user): void
    {

    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(user $user): void
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(user $user): void
    {
        //
    }
}
