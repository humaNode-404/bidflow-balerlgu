<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Prdoc;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrController extends Controller
{
    public function show(string $uuid, Request $request): Response
    {
        if ($request->role == "user") {

        } else {
            $prdoc = Prdoc::where('uuid', $uuid)->get()->map(fn($pr) => [
                'uuid' => $pr->uuid,
                'number' => $pr->number,
                'mode' => $pr->mode,
                'status' => $pr->status,
                'desc' => $pr->desc,
                'event_need' => $pr->event_need,
                'office' => Office::find($pr->office)->only(['abbr', 'name']),
                'user' => User::find($pr->user)->only(['uuid', 'name', 'role', 'avatar']),
                'created_at' => Carbon::parse($pr->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        return Inertia::render('pr/Pr', [
            'prdoc' => $prdoc,
        ]);
    }
}
