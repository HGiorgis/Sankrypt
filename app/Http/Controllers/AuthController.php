<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private function generateApiKey(): string
    {
        return 'SK' . strtoupper(Str::random(32));
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'auth_key_hash' => 'required|string|min:64|max:64',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'email' => $request->email,
                'auth_key_hash' => $request->auth_key_hash,
                'security_settings' => [
                    'session_timeout' => 30,
                    'two_factor_enabled' => false,
                    'max_login_attempts' => 5,
                    'auto_lock' => true,
                ],
                'password_changed_at' => now(),
                'api_key' => $this->generateApiKey(),
            ]);

            AccessLog::create([
                'user_id' => $user->id,
                'action' => 'register',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => TRUE,
                'details' => 'User registered successfully'
            ]);

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'api_key' => $user->api_key, 
                    'security_settings' => $user->security_settings,
                ],
                'token' => $token
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return response()->json([
                'error' => 'Registration failed',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'auth_key_hash' => 'required|string|min:64|max:64',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid input data'
            ], 422);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'error' => 'Invalid email or password'
                ], 401);
            }

            if (!hash_equals($user->auth_key_hash, $request->auth_key_hash)) {
                AccessLog::create([
                    'user_id' => $user->id,
                    'action' => 'login',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'success' => FALSE, // Changed from 0 to false
                    'details' => 'Invalid password'
                ]);

                return response()->json([
                    'error' => 'Invalid email or password'
                ], 401);
            }

            $user->update(['last_login_at' => now()]);
            $token = $user->createToken('auth-token')->plainTextToken;

            AccessLog::create([
                'user_id' => $user->id,
                'action' => 'login',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => TRUE, // Changed from 1 to true
                'details' => 'Login successful'
            ]);

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'security_settings' => $user->security_settings,
                    'api_key' => $user->api_key, 
                ],
                'token' => $token
            ]);

        } catch (\Exception $e) {
            \Log::error('Login failed', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);
            
            return response()->json([
                'error' => 'Login failed. Please try again.'
            ], 500);
        }
    }
    public function logout(Request $request): JsonResponse
    {
        try {
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'logout',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => TRUE,
                'details' => 'Logout successful'
            ]);

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout successful'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Logout failed',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'email' => $request->user()->email,
                'security_settings' => $request->user()->security_settings,
                'last_login_at' => $request->user()->last_login_at,
            ]
        ]);
    }
    public function changePassword(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'current_auth_hash' => 'required|string|min:64|max:64',
        'new_auth_hash' => 'required|string|min:64|max:64',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Validation failed',
            'details' => $validator->errors()
        ], 422);
    }

    try {
        $user = $request->user();

        // Verify current auth hash
        if (!hash_equals($user->auth_key_hash, $request->current_auth_hash)) {
            AccessLog::create([
                'user_id' => $user->id,
                'action' => 'password_change',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => false,
                'details' => 'Invalid current password'
            ]);

            return response()->json([
                'error' => 'Current password is incorrect'
            ], 401);
        }

        // Update to new auth hash
        $user->update([
            'auth_key_hash' => $request->new_auth_hash,
            'password_changed_at' => now(),
        ]);

        AccessLog::create([
            'user_id' => $user->id,
            'action' => 'password_change',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'success' => true,
            'details' => 'Password changed successfully'
        ]);

        return response()->json([
            'message' => 'Password changed successfully'
        ]);

    } catch (\Exception $e) {
        AccessLog::create([
            'user_id' => $request->user()->id,
            'action' => 'password_change',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'success' => false,
            'details' => 'Failed to change password: ' . $e->getMessage()
        ]);

        return response()->json([
            'error' => 'Failed to change password',
            'details' => $e->getMessage()
        ], 500);
    }
}
}