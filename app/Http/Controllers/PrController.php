<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Prdoc;
use App\Models\StageAction;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrController extends Controller
{
  public function show(string $number, Request $request): Response
  {

    $prdoc = Prdoc::withTrashed()->where('number', $number)->get()->map(fn($pr) => [
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
      'deleted_at' => $pr->deleted_at,
      'failed_at' => $pr->failed_at,
      'can_update' => $pr->can_update,
      'office' => Office::find($pr->office_id)->only(['abbr', 'name']),
      'user' => User::withTrashed()->find($pr->user_id)->only(['uuid', 'name', 'role', 'avatar']),
      'created_at' => Carbon::parse($pr->created_at)->format('Y-m-d H:i:s'),
      'stages' => StageAction::where('prdoc_id', $pr->id)
        ->orderBy('proc_no', 'desc')->get()->map(fn($stage) => [
          'id' => $stage->id,
          'uuid' => $stage->uuid,
          'proc_no' => $stage->proc_no,
          'main_proc' => $stage->main_proc,
          'proc' => $stage->proc,
          'desc' => $stage->desc,
          'status' => $stage->status,
          'attachment' => $stage->attachment,
          'created_at' => Carbon::parse($stage->created_at),
          'updated_at' => Carbon::parse($stage->updated_at),
        ]),
      'assigned_stage' => StageAction::where('prdoc_id', $pr->id)
        ->orderBy('proc_no', 'desc')->first(),
    ])->first();

    $prModes = json_decode(file_get_contents(storage_path('app/pr_modes.json')), true);

    return Inertia::render('PR', [
      'prdoc' => Inertia::defer(fn() => $prdoc),
      'prModes' => Inertia::defer(fn() => $prModes ?: []),
    ]);
  }

  public function delete(string $number, Request $request)
  {
    $prdoc = Prdoc::withTrashed()->where('number', $number)->first();
    if ($prdoc->trashed()) {
      $prdoc->restore();
    } else
      $prdoc->delete();
  }
}
