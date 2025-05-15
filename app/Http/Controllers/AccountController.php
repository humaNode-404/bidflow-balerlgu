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

class AccountController extends Controller
{

    public function show()
    {
        $acc = Auth::user();

        $offices = Office::select('id', 'name', 'abbr')->distinct()->get();
        return Inertia::render('Account', [
            "offices" => Inertia::defer(fn() => $offices),
            "acc" => Inertia::defer(fn() => $acc),
        ]);
    }


    public function updateInfo(AccInfoRequest $request)
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

            $existingFiles = glob(storage_path('app/public/avatars/avatar-user-' . $user->id . '.*'));
            foreach ($existingFiles as $existingFile) {
                unlink($existingFile);
            }

            $fileExtension = $request->file('avatar')->getClientOriginalExtension();
            $fileName = 'avatar-user-' . $user->id . '.' . $fileExtension;

            // Store the file and overwrite if it already exists
            $avatarPath = $request->file('avatar')->storeAs('avatars', $fileName, 'public');

            // Update the avatar path in the database
            $user->avatar = '/storage/' . $avatarPath;
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

        return redirect()->back()->with('success', 'Information updated successfully!');
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

        return redirect()->back();
    }

}
