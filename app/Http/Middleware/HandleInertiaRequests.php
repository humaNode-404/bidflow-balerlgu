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
    $user = Auth::user();
    $per_page = 20;
    $notifPage = $request->notifpage;
    $notifications = Auth::user()?->notifications()
      ->latest()
      ->paginate($per_page, page: $notifPage)
      ->setPageName('notifpage');
    $unReadNo = Auth::user()?->unreadNotifications()->count();

    return [
      ...parent::share($request), // Include the parent's share data.
      'notifs' => Inertia::defer(fn() => ['pages' => $notifications, 'unReadNo' => $unReadNo])->deepMerge(),
      'flash' => $request, // Share flash session data.
      'auth' => Inertia::always(fn() => [
        'user' => Inertia::defer(fn() => $user?->only([
          'id',
          'name',
          'first_name',
          'email_verified_at',
          'role',
          'avatar',
        ])),
        'roles' => Auth::user()?->getRoleNames() ?? [],
        'permissions' => Auth::user()?->getAllPermissions()->pluck('name') ?? [],
      ]),
    ];
  }
}
