<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $per_page = 1;
        $notifPage = $request->notifpage;
        $notifications = Auth::user()?->notifications()
            ->latest()
            ->paginate($per_page, page: $notifPage)
            ->setPageName('notifpage');
        $unReadNo = Auth::user()?->unreadNotifications()->count();
        return response()->json([
            'output' => $exception
        ], 500);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $user = Auth::user();

        $notification = $user->notifications()->findOrFail($id);
        if (is_null($notification->read_at))
            $notification->markAsRead();
        else
            $notification->markAsUnread();

        return back();
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();
        return back();
    }

    public function deleteAll()
    {
        $user = Auth::user();
        $user->notifications()->delete();
        return back();
    }
}
