<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Account\AccInfoRequest;
use Inertia\Inertia;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{

    public function show()
    {
        $acc = Auth::user();
        $can = [
            'editOffice' => $acc->role === 'admin',
        ];

        $offices = Office::select('id', 'name', 'abbr')->distinct()->get();
        return Inertia::render('acc/Account', [
            "filters" => request()->only(['tab']),
            "offices" => $offices ?: null,
            "acc" => $acc ?: null,
            'can' => $can,
        ]);
    }


    public function updateInfo(AccInfoRequest $request): RedirectResponse
    {
        // Access validated data
        $validated = $request->validated();
        $user = Auth::user();

        // Check if a new avatar file is uploaded
        if ($request->hasFile('avatar')) {
            // Validate the file
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:3072',
            ]);

            $fileExtension = $request->file('avatar')->getClientOriginalExtension();
            $fileName = 'avatar-' . $user->uuid . '.' . $fileExtension;

            // Store the file and get the path
            $avatarPath = $request->file('avatar')->storeAs('avatars', $fileName, 'public');

            // Update the avatar path in the database
            $user->avatar = $avatarPath;
        }


        // Update other fields
        $user->first_name = $validated['first_name'];
        $user->middle_name = $validated['middle_name'];
        $user->last_name = $validated['last_name'];
        $user->address = $validated['address'];
        $user->phone = $validated['phone'];
        $user->office_id = $validated['office_id'];
        $user->email = $validated['email'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        // Redirect back or to a success page
        return redirect()->route('account.show')->with('success', 'Information updated successfully!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }

}
