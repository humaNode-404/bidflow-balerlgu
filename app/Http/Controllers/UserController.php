<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Office;
use App\Models\User;
use App\Http\Requests\User\Create;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Rules\PrOfficeRule;

class UserController extends Controller
{
    public function show()
    {
        $offices = Office::select('id', 'name', 'abbr')->distinct()->get();
        return Inertia::render('users/Users', [
            "offices" => $offices,
            "users" => User::withTrashed()->get()->map(fn($user) => [
                "id" => $user->id,
                "avatar" => $user->avatar,
                "name" => $user->name,
                "first_name" => $user->first_name,
                "middle_name" => $user->middle_name,
                "last_name" => $user->last_name,
                "email" => $user->email,
                "office_id" => $user->office_id,
                "role" => $user->role,
                "status" => $user->status,
                "verified_status" => $user->verified_status,
                "email_verified_at" => $user->email_verified_at,
                "phone" => $user->phone,
                "address" => $user->address,
            ])
        ]);
    }

    public function create(Create $request): RedirectResponse
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
        ]);

        return redirect()->back();
    }

    public function update(Request $request): RedirectResponse
    {

        $validated = $request->validate(
            [
                'first_name' => ['required', 'string', 'max:125'],
                'middle_name' => ['nullable', 'string', 'max:125'],
                'last_name' => ['required', 'string', 'max:125'],
                'address' => ['required', 'string', 'max:125'],
                'phone' => ['required', 'digits:11'],
                'office_id' => ['required', new PrOfficeRule()],
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

        User::where('id', $request['id'])
            ->update($validated);


        return back();
    }

    public function delete(Request $request): RedirectResponse
    {
        $user = User::withTrashed()->find($request->id);

        if ($user->trashed()) {
            $user->restore();
        } else
            $user->delete();


        return back();
    }
}
