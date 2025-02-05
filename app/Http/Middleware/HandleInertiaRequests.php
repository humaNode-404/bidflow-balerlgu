<?php

namespace App\Http\Middleware;


use Illuminate\Http\Request;
use Inertia\Middleware;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = Auth::user(); // Get the currently authenticated user or null.

        $can = $user ? [ // Check if $user is not null.
            'prCreate' => $user->role === 'admin', // Access role safely.
            'prFilter' => $user->role === 'admin' || $user->role === 'mod',
            'userCreate' => $user->role === 'admin',
        ] : []; // If $user is null, default $can to an empty array.

        return [
            ...parent::share($request), // Include the parent's share data.
            'auth' => [
                'user' => Inertia::lazy(fn() => $user ? $user->only([ // Load user data lazily.
                    'uuid',
                    'name',
                    'first_name',
                    'email',
                    'email_verified_at',
                    'role',
                    'avatar',
                ]) : null), // If no user is logged in, return null.
                'can' => $can, // Provide permissions or an empty array.
            ],
        ];
    }
}
