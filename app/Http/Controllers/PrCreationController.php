<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PrCreate\Step1Request;
use App\Http\Requests\PrCreate\Step2Request;
use App\Http\Requests\PrCreate\Step3Request;
use App\Http\Requests\PrCreate\Step4Request;
use App\Http\Requests\PrCreate\Step5Request;
use App\Models\Prdoc;
use App\Models\User;
use App\Models\Stage;
use App\Models\StageAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PrCreationController extends Controller
{
    public function step1(Step1Request $request): RedirectResponse
    {
        // Access validated data
        $request->validated();

        return Redirect::route('dashboard');
    }

    public function step2(Step2Request $request): RedirectResponse
    {
        // Access validated data
        $request->validated();

        return Redirect::route('dashboard');
    }

    public function step3(Step3Request $request): RedirectResponse
    {
        // Access validated data
        $request->validated();

        return Redirect::route('dashboard');
    }

    public function step4(Step4Request $request): RedirectResponse
    {
        // Access validated data
        $request->validated();

        return Redirect::route('dashboard');
    }
    public function step5(Step5Request $request): RedirectResponse
    {
        $validated = $request->validated();

        // Create the PR document
        $prdoc = Prdoc::create([
            'number' => $validated['number'],
            'value' => $validated['value'],
            'mode' => $request->mode,
            'desc' => $validated['desc'],
            'purpose' => $validated['purpose'],
            'event_need' => $validated['event_need'],
            'event_loc' => $validated['event_loc'],
            'office_id' => $validated['office_id'],
            'user_id' => $validated['user_id'],
        ]);



        // Load PR process JSON
        $prProcesses = json_decode(Storage::get('pr_process.json'), true);

        if ($prProcesses && count($prProcesses) > 0) {
            // Initialize the first process
            $firstProcess = $prProcesses[0]; // Get the first process from the array

            StageAction::create([
                'prdoc_id' => $prdoc->id,
                'user_group' => $firstProcess['user_group'],
                'proc_no' => $firstProcess['proc_no'],
                'main_proc' => $firstProcess['main_proc'],
                'proc' => $firstProcess['proc'],
                'incharge' => $firstProcess['incharge'],
                'desc' => $firstProcess['desc'],
            ]);
        }

        return Redirect::route('dashboard');
    }

}
