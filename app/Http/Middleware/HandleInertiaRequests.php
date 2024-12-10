<?php

namespace App\Http\Middleware;

use App\Models\Prdoc;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Inertia\Inertia;

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
        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => Inertia::lazy(fn() => $user ? $user->only([
                    'uuid',
                    'name',
                    'first_name',
                    'email',
                    'role',
                    'avatar',
                ]) : null),
                'bookmarks' => Inertia::lazy(fn() => $user ? Prdoc::where('user', $user->id)
                    ->get(['uuid', 'desc', 'number']) : []),
            ],
        ];
    }
}
