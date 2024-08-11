<?php

namespace App\Http\Controllers\API;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;

class NotificationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return ResponseFormatter::success($notification, 'Notification created successfully');
    }

    public function index()
    {
        $notifications = Notification::all();
        return ResponseFormatter::success($notifications, 'Notifications retrieved successfully');
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return ResponseFormatter::success($notification, 'Notification retrieved successfully');
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return ResponseFormatter::success($notification, 'Notification marked as read');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return ResponseFormatter::success(null, 'Notification deleted successfully');
    }
}
