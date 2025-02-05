<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Prdoc;
use App\Models\StageAction;
use App\Models\Stage;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PrController extends Controller
{
  public function show(string $uuid, Request $request): Response
  {
    $user = Auth::user();
    $offices = Office::select('id', 'name', 'abbr', "user_group")->distinct()->get()->keyBy('id');
    $office = $offices->get($user->office_id);

    $prdoc = Prdoc::withTrashed()->where('uuid', $uuid)->get()->map(fn($pr) => [
      'id' => $pr->id,
      'uuid' => $pr->uuid,
      'value' => $pr->value,
      'number' => $pr->number,
      'mode' => $pr->mode,
      'status' => $pr->status,
      'desc' => $pr->desc,
      'purpose' => $pr->purpose,
      'starred' => $pr->starred,
      'event_need' => $pr->event_need,
      'event_loc' => $pr->event_loc,
      'office_id' => Office::find($pr->office_id)->only(['abbr', 'name']),
      'user_id' => User::find($pr->user_id)->only(['uuid', 'name', 'role', 'avatar']),
      'created_at' => Carbon::parse($pr->created_at)->format('Y-m-d H:i:s'),
      'stages' => StageAction::where('prdoc_id', $pr->id)
        ->orderBy('created_at', 'desc')->get()->map(fn($stage) => [
          'id' => $stage->id,
          'uuid' => $stage->uuid,
          'main_proc' => $stage->main_proc,
          'proc' => $stage->proc,
          'desc' => $stage->desc,
          'status' => $stage->status,
          'attachment' => $stage->attachment,
          'created_at' => Carbon::parse($stage->created_at)->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::parse($stage->updated_at)->format('Y-m-d H:i:s'),
        ]),
      'assigned_stages' => StageAction::where('prdoc_id', $pr->id)
        ->where('user_group', $office->user_group)
        ->orderBy('created_at', 'desc')->get()->map(fn($stage) => [
          'id' => $stage->id,
          'uuid' => $stage->uuid,
          'main_proc' => $stage->main_proc,
          'proc' => $stage->proc,
          'desc' => $stage->desc,
          'status' => $stage->status,
          'attachment' => $stage->attachment,
          'created_at' => Carbon::parse($stage->created_at)->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::parse($stage->updated_at)->format('Y-m-d H:i:s'),
        ]),
    ]);

    $myprdoc = Prdoc::withTrashed()->find($prdoc[0]['id']);
    $prProcesses = json_decode(Storage::get('pr_process.json'), true);

    return Inertia::render('pr/Pr', [
      'prdoc' => $prdoc,
      'can' => [
        'archive' => !$myprdoc->trashed() && count($myprdoc->stageactions()->get()) >= count($prProcesses),
        'view_stages' => !$myprdoc->trashed(),
      ],
    ]);
  }

  public function delete(Prdoc $prdoc, Request $request): RedirectResponse
  {
    if ($prdoc->trashed()) {
      $prdoc->restore();
    } else
      $prdoc->delete();


    return redirect("dashboard");
  }
}
