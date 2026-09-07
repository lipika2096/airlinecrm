<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // Get current user info
        $userId = null;
        $userType = null;

        if (auth('admin')->check()) {
            $userId = auth('admin')->user()->id;
            $userType = 'admin';
        } elseif (auth()->check()) {
            $userId = auth()->user()->id;
            $userType = 'staff';
        }

        if (!$userId || !$userType) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notifications = Notification::forUser($userId, $userType)
            ->with('supportTicket')
            ->latest()
            ->limit(20)
            ->get();

        $unreadCount = Notification::forUser($userId, $userType)
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        // Check if user owns this notification
        $userId = null;
        $userType = null;

        if (auth('admin')->check()) {
            $userId = auth('admin')->user()->id;
            $userType = 'admin';
        } elseif (auth()->check()) {
            $userId = auth()->user()->id;
            $userType = 'staff';
        }

        if ($notification->user_id != $userId || $notification->user_type != $userType) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request)
    {
        $userId = null;
        $userType = null;

        if (auth('admin')->check()) {
            $userId = auth('admin')->user()->id;
            $userType = 'admin';
        } elseif (auth()->check()) {
            $userId = auth()->user()->id;
            $userType = 'staff';
        }

        if (!$userId || !$userType) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Notification::forUser($userId, $userType)
            ->unread()
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        // Check if user owns this notification
        $userId = null;
        $userType = null;

        if (auth('admin')->check()) {
            $userId = auth('admin')->user()->id;
            $userType = 'admin';
        } elseif (auth()->check()) {
            $userId = auth()->user()->id;
            $userType = 'staff';
        }

        if ($notification->user_id != $userId || $notification->user_type != $userType) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification->delete();

        return response()->json(['success' => true]);
    }
}
