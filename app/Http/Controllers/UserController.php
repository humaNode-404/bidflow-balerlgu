<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Office;
use App\Models\User;
use App\Http\Requests\Settings\Users\Create;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $offices = Office::select('id', 'name', 'abbr')->distinct()->get();
        return Inertia::render('settings/Users', [
            "offices" => Inertia::defer(fn() => $offices),
            "users" => Inertia::defer(fn() =>
                User::withTrashed()->get()->map(fn($user) => [
                    "id" => $user->id,
                    "avatar" => $user->avatar,
                    "name" => $user->name,
                    "first_name" => $user->first_name,
                    "middle_name" => $user->middle_name,
                    "last_name" => $user->last_name,
                    "email" => $user->email,
                    "office" => $user->office->only(['id', 'abbr', 'name']),
                    "role" => $user->role,
                    "status" => $user->status,
                    "verified_status" => $user->verified_status,
                    "email_verified_at" => $user->email_verified_at,
                    "phone" => $user->phone,
                    "address" => $user->address,
                ])),
        ]);
    }

    public function store(Create $request): RedirectResponse
    {
        $validated = $request->validated();

        // Create the User
        User::create([
            'office_id' => $validated['office_id'],
            'role' => $validated['role'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'
            ],
            'password' => $request['email'] . '_' . $request['office_id'],
        ])->assignRole($validated['role']);

        return redirect()->back();
    }

    public function update(Request $request, string $id): RedirectResponse
    {

        $validated = $request->validate(
            [
                'first_name' => ['required', 'string', 'max:125'],
                'middle_name' => ['nullable', 'string', 'max:125'],
                'last_name' => ['required', 'string', 'max:125'],
                'address' => ['required', 'string', 'max:125'],
                'phone' => ['required', 'digits:11'],
                'office_id' => ['required', 'exists:offices,id'],
                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique(User::class)->ignore($request['id']),
                ],
            ]
        );

        $user = User::findOrFail($request['id']);
        $user->update($validated);

        return back();
    }

    public function destroy(string $id)
    {
        $user = User::withTrashed()->find($id);

        if ($user->trashed()) {
            $user->restore();
        } else
            $user->delete();


        return back();
    }
}