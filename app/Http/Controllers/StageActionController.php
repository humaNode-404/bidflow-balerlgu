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
        return Inertia::render("pr/StageActions", [
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
            $fileExtension = $request->file('attachment')->getClientOriginalExtension();
            $fileName = 'attachment-' . $stageaction->uuid . '.' . $fileExtension;
            $filePath = $request->file('attachment')->storeAs('attachments', $fileName, 'public');
            $stageaction->attachment = $filePath;
        }

        $stageaction->save();
        // dd($stageaction);


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
        // dd($prProcesses[$stageaction->proc_no]);

        $stageaction->desc = $prProcesses[$stageaction->proc_no - 1]['desc'];

        if ($stageaction->proc_no < count($prProcesses)) {

            $process = $prProcesses[$stageaction->proc_no];
            $status = $stageaction->proc_no == (count($prProcesses) - 1) ? "completed" : "pending";

            StageAction::create([
                'prdoc_id' => $stageaction->prdoc_id,
                'user_group' => $process['user_group'],
                'proc_no' => $process['proc_no'],
                'main_proc' => $process['main_proc'],
                'proc' => $process['proc'],
                'incharge' => $process['incharge'],
                'desc' => "Waiting for the incharge office to received the documents",
                'status' => $status,
            ]);
        }

        $stageaction->save();

        return redirect()->back();
    }


}
