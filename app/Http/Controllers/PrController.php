<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Prdoc;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

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
        'starred' => $pr->starred,
        'event_need' => $pr->event_need,
        'office' => Office::find($pr->office)->only(['abbr', 'name']),
        'user' => User::find($pr->user)->only(['uuid', 'name', 'role', 'avatar']),
        'created_at' => Carbon::parse($pr->created_at)->format('Y-m-d H:i:s'),

        'files' => $this->getFile('flowchart-paper-based.pdf'),
      ]);
    }

    return Inertia::render('pr/Pr', [
      'prdoc' => $prdoc,
    ]);
  }

  public function getFile($filename)
  {
    $filePath = sprintf('public/%s', $filename);
    if (Storage::exists($filePath)) {
      return response()->json([
        'fileUrl' => Storage::url($filePath),

      ]);
    } else {
      return response()->json(['error' => 'File not found', 'filename' => $filePath], 404);
    }
  }
}
