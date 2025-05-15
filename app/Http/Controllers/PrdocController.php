<?php

namespace App\Http\Controllers;

use App\Models\Prdoc;
use App\Http\Requests\StorePrdocRequest;
use App\Http\Requests\UpdatePrdocRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Models\StageAction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PrdocController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $formStep = $request->step;
    $rules = (new StorePrdocRequest())->rules();
    $step1Rules = Arr::only($rules, ['number', 'value', 'mode']);
    $step2Rules = Arr::only($rules, ['desc', 'purpose']);
    $step3Rules = Arr::only($rules, ['event_need', 'event_loc']);
    $step4Rules = Arr::only($rules, ['user_id']);

    switch ($formStep) {
      case 1:
        Validator::make($request->all(), $step1Rules)->validate();
        return Redirect::back();
      case 2:
        Validator::make($request->all(), $step2Rules)->validate();
        return Redirect::back();
      case 3:
        Validator::make($request->all(), $step3Rules)->validate();
        return Redirect::back();
      case 4:
        Validator::make($request->all(), $step4Rules)->validate();
        return Redirect::back();
      default:
        $validated = Validator::make($request->all(), $rules)->validate();
    }

    // Create the PR document
    $prdoc = Prdoc::create([
      'number' => $validated['number'],
      'value' => $validated['value'],
      'mode' => $validated['mode'],
      'desc' => $validated['desc'],
      'purpose' => $validated['purpose'],
      'event_need' => $validated['event_need'],
      'event_loc' => $validated['event_loc'],
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

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Prdoc $prdoc)
  {
    $rules = Arr::only((new StorePrdocRequest())->rules(), ['value', 'mode', 'desc', 'purpose', 'event_loc']);

    $rules['event_need'] = [
      'required',
      'date',
      'after_or_equal:today',
      'before_or_equal:' . now()->addMonths(6)->toDateString(),
    ];

    $validated = Validator::make($request->all(), $rules)->validate();

    $prdoc->update([
      'value' => $validated['value'],
      'mode' => $validated['mode'],
      'desc' => $validated['desc'],
      'purpose' => $validated['purpose'],
      'event_need' => $validated['event_need'],
      'event_loc' => $validated['event_loc'],
    ]);

    $prdoc->save();

    return Redirect::back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Prdoc $prdoc)
  {
    $prdoc->update([
      'failed_at' => now(),
    ]);

    $prdoc->save();

    return Redirect::back();
  }

  /**
   * Display the specified resource.
   */
  public function show(Prdoc $prdoc)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Prdoc $prdoc)
  {
    //
  }
}
