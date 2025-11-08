<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updatePreferences(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'preferences' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $user->update([
                'preferences' => json_encode($request->preferences)
            ]);

            AccessLog::create([
                'user_id' => $user->id,
                'action' => 'preferences_update',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => true,
                'details' => 'Updated user preferences'
            ]);

            return response()->json([
                'message' => 'Preferences updated successfully',
                'preferences' => $user->preferences
            ]);

        } catch (\Exception $e) {
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'preferences_update',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => false,
                'details' => 'Failed to update preferences: ' . $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Failed to update preferences',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function getSecuritySettings(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return response()->json([
                'security_settings' => $user->security_settings,
                'password_changed_at' => $user->password_changed_at,
                'last_login_at' => $user->last_login_at
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch security settings',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}