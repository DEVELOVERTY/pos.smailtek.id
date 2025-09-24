<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class NotificationController extends Controller
{
    /**
     * Create transaction error notification
     */
    public function createTransactionError(Request $request)
    {
        $errorData = [
            'timestamp' => now()->toISOString(),
            'error_type' => $request->input('error_type'),
            'error_message' => $request->input('error_message'),
            'transaction_code' => $request->input('transaction_code'),
            'user_id' => $request->input('user_id'),
            'store_token' => $request->input('store_token'),
            'store_id' => session('mystore'),
            'cashier_session' => session()->getId(),
            'details' => $request->input('details', []),
            'severity' => $this->determineSeverity($request->input('error_type')),
            'requires_admin' => $this->requiresAdmin($request->input('error_type')),
            'status' => 'pending'
        ];

        // Store in cache for real-time access
        $notificationId = 'transaction_error_' . uniqid();
        Cache::put($notificationId, $errorData, now()->addHours(24));

        // Store in session for current user
        $sessionErrors = session('transaction_errors', []);
        $sessionErrors[] = $errorData;
        session(['transaction_errors' => $sessionErrors]);

        // Log for admin monitoring
        Log::channel('transaction_errors')->error('Transaction Error', $errorData);

        return response()->json([
            'success' => true,
            'notification_id' => $notificationId,
            'message' => 'Error notification created',
            'data' => $errorData
        ]);
    }

    /**
     * Get pending notifications for admin
     */
    public function getPendingNotifications()
    {
        $notifications = [];
        
        // Get from session
        $sessionErrors = session('transaction_errors', []);
        
        // Get from cache (for all sessions)
        $cacheKeys = Cache::get('notification_keys', []);
        foreach ($cacheKeys as $key) {
            $notification = Cache::get($key);
            if ($notification && $notification['status'] === 'pending') {
                $notifications[] = $notification;
            }
        }

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'count' => count($notifications)
        ]);
    }

    /**
     * Mark notification as resolved
     */
    public function resolveNotification(Request $request)
    {
        $notificationId = $request->input('notification_id');
        $resolution = $request->input('resolution');
        $resolvedBy = $request->input('resolved_by', 'admin');

        $notification = Cache::get($notificationId);
        if ($notification) {
            $notification['status'] = 'resolved';
            $notification['resolved_at'] = now()->toISOString();
            $notification['resolved_by'] = $resolvedBy;
            $notification['resolution'] = $resolution;
            
            Cache::put($notificationId, $notification, now()->addDays(7));
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification resolved',
            'notification_id' => $notificationId
        ]);
    }

    /**
     * Determine error severity
     */
    private function determineSeverity($errorType)
    {
        $severityMap = [
            'invalid_token' => 'high',
            'token_not_found' => 'high',
            'user_not_found' => 'medium',
            'user_inactive' => 'medium',
            'limit_exceeded' => 'medium',
            'unpaid_bills' => 'medium',
            'kedit_connection_error' => 'high',
            'fingerprint_verification_failed' => 'medium',
            'transaction_validation_failed' => 'high'
        ];

        return $severityMap[$errorType] ?? 'medium';
    }

    /**
     * Check if error requires admin intervention
     */
    private function requiresAdmin($errorType)
    {
        $adminRequired = [
            'invalid_token',
            'token_not_found', 
            'kedit_connection_error',
            'transaction_validation_failed'
        ];

        return in_array($errorType, $adminRequired);
    }
}
