<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = Office::select('id', 'name', 'abbr')->distinct()->get();
        return Inertia::render('settings/Offices', [
            "offices" => Inertia::defer(fn() => $offices),
        ]);
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
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'min:5',
                    'max:30',
                    Rule::unique(Office::class),
                ],
                'abbr' => [
                    'required',
                    'string',
                    'uppercase',
                    'max:5',
                    Rule::unique(Office::class),
                ],
            ]
        );

        Office::create($validated);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Office $office)
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:30',
                    Rule::unique(Office::class)->ignore($office->id),
                ],
                'abbr' => [
                    'required',
                    'string',
                    'uppercase',
                    'max:5',
                    Rule::unique(Office::class)->ignore($office->id),
                ],
            ]
        );

        $office->update($validated);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        //
    }
}
