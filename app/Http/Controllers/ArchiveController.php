<?php

namespace App\Http\Controllers;

use App\Models\Prdoc;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    public function show(Request $request): Response
    {
        $user = Auth::user();

        $completed = Prdoc::onlyTrashed()->when(request('search'), function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhere('desc', 'like', "%{$search}%")
                    ->orWhere('mode', 'like', "%{$search}%");
            });
        })
            ->when($user->role === 'end-user', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($prdoc) => [
                'uuid' => $prdoc->uuid,
                'number' => $prdoc->number,
                'mode' => $prdoc->mode,
                'priority_level' => $prdoc->priority_level,
                'completed_at' => $prdoc->deleted_at,
                'desc' => $prdoc->desc,
                'event_need' => $prdoc->event_need,
                'office_id' => $prdoc->office->only(['abbr', 'name']),
                'user_id' => $prdoc->user->only(['uuid', 'status', 'name', 'role', 'avatar']),
                'created_at' => $prdoc->created_at,
                'progress' => $prdoc->stage_progress,
                'current_progress' => $prdoc->stage_count,
                'count_progress' => $prdoc->max_progress,
                'stage' => $prdoc->stageactions->sortByDesc('proc_no')->first(),
            ]);

        $failed = Prdoc::failed()->when(request('search'), function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhere('desc', 'like', "%{$search}%")
                    ->orWhere('mode', 'like', "%{$search}%");
            });
        })
            ->when($user->role === 'end-user', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($prdoc) => [
                'uuid' => $prdoc->uuid,
                'number' => $prdoc->number,
                'mode' => $prdoc->mode,
                'priority_level' => $prdoc->priority_level,
                'failed_at' => $prdoc->failed_at,
                'desc' => $prdoc->desc,
                'event_need' => $prdoc->event_need,
                'office_id' => $prdoc->office->only(['abbr', 'name']),
                'user_id' => $prdoc->user->only(['uuid', 'status', 'name', 'role', 'avatar']),
                'created_at' => $prdoc->created_at,
                'progress' => $prdoc->stage_progress,
                'current_progress' => $prdoc->stage_count,
                'count_progress' => $prdoc->max_progress,
                'stage' => $prdoc->stageactions->sortByDesc('proc_no')->first(),
            ]);

        return Inertia::render('Archive', [
            'completed' => Inertia::defer(fn() => $completed),
            'failed' => Inertia::optional(fn() => $failed),
        ]);
    }

}