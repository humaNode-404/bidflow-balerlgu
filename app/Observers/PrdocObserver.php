<?php

namespace App\Observers;

use App\Models\Prdoc;
use App\Models\User;
use App\Notifications\NewPurchaseRequest;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Notification;

class PrdocObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Prdoc "created" event.
     */
    public function created(Prdoc $prdoc): void
    {
        $usersWithRoles = User::role(['admin', 'bac'])->get();
        $users = $usersWithRoles->push($prdoc->user)->unique('id');
        Notification::send($users, new NewPurchaseRequest($prdoc));
    }

    /**
     * Handle the Prdoc "updated" event.
     */
    public function updated(Prdoc $prdoc): void
    {

    }

    /**
     * Handle the Prdoc "deleted" event.
     */
    public function deleted(Prdoc $prdoc): void
    {
        //
    }

    /**
     * Handle the Prdoc "restored" event.
     */
    public function restored(Prdoc $prdoc): void
    {
        //
    }

    /**
     * Handle the Prdoc "force deleted" event.
     */
    public function forceDeleted(Prdoc $prdoc): void
    {
        //
    }
}
