<?php

namespace App\Observers;

use App\Models\StageAction;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Storage;

class StageActionObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the StageAction "created" event.
     */
    public function created(StageAction $stageAction): void
    {
        //
    }

    /**
     * Handle the StageAction "updated" event.
     */
    public function updated(StageAction $stageAction): void
    {
        $prdoc = $stageAction->prdoc()->first();
        $prProcesses = json_decode(Storage::get('static-data/pr_process.json'), true);

        if ($prdoc && count($prProcesses) == $prdoc->stage_count) {
            if (!is_null($stageAction->completed_at)) {
                $prdoc->delete();
            }
        }
    }

    /**
     * Handle the StageAction "deleted" event.
     */
    public function deleted(StageAction $stageAction): void
    {
        //
    }

    /**
     * Handle the StageAction "restored" event.
     */
    public function restored(StageAction $stageAction): void
    {
        //
    }

    /**
     * Handle the StageAction "force deleted" event.
     */
    public function forceDeleted(StageAction $stageAction): void
    {
        //
    }
}