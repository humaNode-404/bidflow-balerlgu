<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use App\Models\Prdoc;
use App\Notifications\NewPurchaseRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
  public function show(Request $request): Response
  {
    // $command = '"C:\Program Files\LibreOffice\program\soffice.exe" --headless --convert-to pdf "C:\Users\Azenith\Desktop\Aze_Narrative.docx" --outdir "C:\Users\Azenith\Desktop"';
    // exec($command);
    $user = Auth::user();

    $prProcesses = json_decode(Storage::get('pr_process.json'), true);

    $prdocs = Prdoc::query()->notFailed()->when(request('search'), function ($query, $search) {
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
        'days_left' => (\Carbon\Carbon::parse($prdoc->event_need)->diffInDays(now())),
        'desc' => $prdoc->desc,
        'event_need' => $prdoc->event_need,
        'office_id' => $prdoc->office->only(['abbr', 'name']),
        'user_id' => $prdoc->user->only(['uuid', 'status', 'name', 'role', 'avatar']),
        'created_at' => $prdoc->created_at,
        'progress' => intval(($prdoc->stage_count / count($prProcesses)) * 100),
        'current_progress' => count($prdoc->stageactions()->get()),
        'count_progress' => count($prProcesses),
        'stage' => $prdoc->stageactions->sortByDesc('created_at')->first(),
      ]);

    $prdocs_priority = Prdoc::query()->notFailed()->when(request('search'), function ($query, $search) {
      $query->where(function ($q) use ($search) {
        $q->where('number', 'like', "%{$search}%")
          ->orWhere('desc', 'like', "%{$search}%")
          ->orWhere('mode', 'like', "%{$search}%");
      });
    })
      ->when($user->role === 'end-user', function ($query) use ($user) {
        $query->where('user_id', $user->id);
      })
      ->get()
      ->filter(fn($prdoc) => $prdoc->priority_level > 1) // Filter for priority level above 1
      ->sortByDesc(fn($prdoc) => $prdoc->priority_level)
      ->map(fn($prdoc) => [
        'uuid' => $prdoc->uuid,
        'number' => $prdoc->number,
        'mode' => $prdoc->mode,
        'priority_level' => $prdoc->priority_level,
        'days_left' => (Carbon::parse($prdoc->event_need)->diffInDays(now())),
        'desc' => $prdoc->desc,
        'event_need' => $prdoc->event_need,
        'office_id' => $prdoc->office->only(['abbr', 'name']),
        'user_id' => $prdoc->user->only(['uuid', 'status', 'name', 'role', 'avatar']),
        'created_at' => $prdoc->created_at,
        'progress' => intval(($prdoc->stage_count / count($prProcesses)) * 100),
        'current_progress' => count($prdoc->stageactions()->get()),
        'count_progress' => count($prProcesses),
        'stage' => $prdoc->stageactions->sortByDesc('created_at')->first(),
      ]);



    $prModes = json_decode(file_get_contents(storage_path('app/pr_modes.json')), true);

    $offices = Office::all()->select(['id', 'name', 'abbr']);
    $users = User::where('role', 'end-user')
      ->select('id', 'first_name', 'last_name', 'office_id', 'avatar')
      ->get()
      ->map(fn($user) => [
        "id" => $user->id,
        "office_id" => $user->office_id,
        "name" => "{$user->first_name} {$user->last_name}",
        "avatar" => $user->avatar,
      ]);

    // $user->notify(new NewPurchaseRequest(Prdoc::findOrFail(4)));
    // $user->notify(new NewPurchaseRequest(Prdoc::findOrFail(6)));
    // $user->notify(new NewPurchaseRequest(Prdoc::findOrFail(7)));
    // $user->notify(new NewPurchaseRequest(Prdoc::findOrFail(9)));
    // $user->notify(new NewPurchaseRequest(Prdoc::findOrFail(7)));
    // $user->notify(new NewPurchaseRequest(Prdoc::findOrFail(9)));

    return Inertia::render('Dashboard', [
      'prdocs' => Inertia::defer(fn() => $prdocs),
      'priorities' => Inertia::optional(fn() => $prdocs_priority),
      'prModes' => Inertia::defer(fn() => $prModes ?: []),
      'offices' => Inertia::lazy(fn() => $offices ?: []),
      'users' => Inertia::lazy(fn() => $users ?: []),
    ]);
  }
}
