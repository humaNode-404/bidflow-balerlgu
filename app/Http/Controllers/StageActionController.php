<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\StageAction;
use App\Models\Prdoc;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class StageActionController extends Controller
{

    public function show(Prdoc $prdoc, StageAction $stageaction, Request $request)
    {
        return Inertia::render("PR/Stage", [
            'stage' => $stageaction->toArray(),
        ]);
    }
    public function submit(Request $request, StageAction $stageaction)
    {
        $request->validate([
            'notes' => ['nullable', 'min:15', 'max:255',],
            'attachment' => 'nullable|file|mimes:pdf',
        ]);

        $stageaction->notes = $request->notes;
        $stageaction->status = 'on hold';

        if ($request->hasFile('attachment')) {
            $fileName = $request->file('attachment')->getClientOriginalName();
            $filePath = $request->file('attachment')->storeAs('attachments/pr-' . $stageaction->prdoc->number, $fileName, 'public');
            $stageaction->attachment = "/storage/" . $filePath;
        }

        $stageaction->save();


        return redirect()->back();
    }

    public function received(StageAction $stageaction)
    {
        $stageaction->status = 'in progress';
        $stageaction->received_at = now();
        $stageaction->desc = "Documents received by the incharge office";
        $stageaction->save();

        return redirect()->back();
    }

    public function proceed(StageAction $stageaction)
    {
        $stageaction->status = 'completed';
        $stageaction->received_at = now();
        $stageaction->completed_at = now();

        // Load PR process JSON
        $prProcesses = json_decode(Storage::get('pr_process.json'), true);

        if ($stageaction->proc_no < count($prProcesses)) {

            $process = $prProcesses[$stageaction->proc_no];


            $stage = StageAction::create([
                'prdoc_id' => $stageaction->prdoc_id,
                'user_group' => $process['user_group'],
                'proc_no' => $process['proc_no'],
                'main_proc' => $process['main_proc'],
                'proc' => $process['proc'],
                'incharge' => $process['incharge'],
                'desc' => "Waiting for the incharge office to received the documents",
                'status' => "pending",
            ]);
        }

        $stageaction->save();

        return redirect()->back();
    }


}
