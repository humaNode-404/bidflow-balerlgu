<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Prdoc;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function show(Request $request): Response
  {
    if ($request->role == "user") {

    } else {
      $prdocs = Prdoc::all()->map(fn($prdoc) => [
        'uuid' => $prdoc->uuid,
        'number' => $prdoc->number,
        'mode' => $prdoc->mode,
        'status' => $prdoc->status,
        'desc' => $prdoc->desc,
        'event_need' => $prdoc->event_need,
        'office' => Office::find($prdoc->office_id)->only(['abbr', 'name']),
        'user' => User::find($prdoc->user_id)->only(['uuid', 'name', 'role', 'avatar']),
        'created_at' => Carbon::parse($prdoc->created_at)->format('Y-m-d H:i:s'),
      ]);
    }

    return Inertia::render('Dashboard', [
      'prdocs' => Inertia::lazy(fn() => $prdocs),
    ]);
  }
}
