<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stage;
use App\Models\Office;
use App\Models\Prdoc;
use App\Models\StageAction;
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
    $user = Auth::user();
    $can = [
      'prCreate' => Auth::user()->role == 'admin',
      'prFilter' => Auth::user()->role == 'admin' || Auth::user()->role == 'mod',
    ];

    $prProcesses = json_decode(Storage::get('pr_process.json'), true);


    $prdocs = Prdoc::query()->when(request('search'), function ($query, $search) {
      $query->where(function ($q) use ($search) {
        $q->where('number', 'like', "%{$search}%")
          ->orWhere('desc', 'like', "%{$search}%")
          ->orWhere('mode', 'like', "%{$search}%");
      });
    })
      ->when($user->role === 'user', function ($query) use ($user) {
        $query->where('user_id', $user->id);
      })
      ->orderBy('created_at', 'desc')
      ->get()
      ->map(fn($prdoc) => [
        'uuid' => $prdoc->uuid,
        'number' => $prdoc->number,
        'mode' => $prdoc->mode,
        'status' => $prdoc->status,
        'desc' => $prdoc->desc,
        'event_need' => $prdoc->event_need,
        'office_id' => Office::find($prdoc->office_id)->only(['abbr', 'name']),
        'user_id' => User::find($prdoc->user_id)->only(['uuid', 'status', 'name', 'role', 'avatar']),
        'created_at' => Carbon::parse($prdoc->created_at)->format('Y-m-d H:i:s'),
        'progress' => intval((count($prdoc->stageactions()->get()) / count($prProcesses)) * 100),
        'current_progress' => count($prdoc->stageactions()->get()),
        'count_progress' => count($prProcesses),
        'stage' => StageAction::where('prdoc_id', $prdoc->id)
          ->orderBy('created_at', 'desc')
          ->first(),
      ]);


    $prModes = json_decode(file_get_contents(storage_path('app/pr_modes.json')), true);
    $offices = json_decode(file_get_contents(storage_path('app/offices.json')), true);

    $officesWithIds = array_map(function ($office, $index) {
      return array_merge($office, ['id' => $index + 1]);
    }, $offices, array_keys($offices));

    $users = User::where('role', 'user')
      ->select('id', 'first_name', 'last_name', 'office_id', 'avatar')
      ->get()
      ->map(fn($user) => [
        "id" => $user->id,
        "office_id" => $user->office_id,
        "name" => "{$user->first_name} {$user->last_name}",
        "avatar" => $user->avatar,
      ]);


    return Inertia::render('Dashboard', [
      'prdocs' => Inertia::defer(fn() => $prdocs),
      'filters' => request(['search']),
      'prModes' => Inertia::lazy(fn() => $prModes ?: []),
      'offices' => Inertia::lazy(fn() => $officesWithIds ?: []),
      'users' => Inertia::lazy(fn() => $users ?: []),
      'can' => $can,
    ]);
  }
}
