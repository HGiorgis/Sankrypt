<?php

namespace App\Http\Controllers;

use App\Models\Vault;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class VaultController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $vaults = Vault::where('user_id', $request->user()->id)
                          ->get(['id', 'category', 'data_hash', 'created_at', 'last_accessed_at']);

            // Log the access
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_access',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => true,
                'details' => 'Accessed vault list'
            ]);

            return response()->json([
                'vaults' => $vaults,
                'count' => $vaults->count()
            ]);

        } catch (\Exception $e) {
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_access',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => false,
                'details' => 'Failed to access vault list: ' . $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Failed to fetch vault items',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:50',
            'encrypted_data' => 'required|string',
            'encryption_salt' => 'required|string',
            'data_hash' => 'required|string|min:128|max:128',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        try {
            $vault = Vault::create([
                'user_id' => $request->user()->id,
                'category' => $request->category,
                'encrypted_data' => $request->encrypted_data,
                'encryption_salt' => $request->encryption_salt,
                'data_hash' => $request->data_hash,
            ]);

            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_store',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => true,
                'details' => 'Stored new vault item in category: ' . $request->category
            ]);

            return response()->json([
                'message' => 'Vault item stored successfully',
                'id' => $vault->id
            ], 201);

        } catch (\Exception $e) {
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_store',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => false,
                'details' => 'Failed to store vault item: ' . $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Failed to store vault item',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, string $id): JsonResponse
    {
        try {
            $vault = Vault::where('user_id', $request->user()->id)
                         ->findOrFail($id);

            $vault->touchLastAccessed();

            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_retrieve',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => true,
                'details' => 'Retrieved vault item: ' . $id
            ]);

            return response()->json([
                'vault' => [
                    'id' => $vault->id,
                    'category' => $vault->category,
                    'encrypted_data' => $vault->encrypted_data,
                    'encryption_salt' => $vault->encryption_salt,
                    'data_hash' => $vault->data_hash,
                    'version' => $vault->version,
                    'last_accessed_at' => $vault->last_accessed_at,
                ]
            ]);

        } catch (\Exception $e) {
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_retrieve',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => false,
                'details' => 'Failed to retrieve vault item: ' . $id
            ]);

            return response()->json([
                'error' => 'Vault item not found'
            ], 404);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'encrypted_data' => 'required|string',
            'encryption_salt' => 'required|string',
            'data_hash' => 'required|string|min:128|max:128',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        try {
            $vault = Vault::where('user_id', $request->user()->id)
                         ->findOrFail($id);

            $vault->update([
                'encrypted_data' => $request->encrypted_data,
                'encryption_salt' => $request->encryption_salt,
                'data_hash' => $request->data_hash,
            ]);

            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_update',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => true,
                'details' => 'Updated vault item: ' . $id
            ]);

            return response()->json([
                'message' => 'Vault item updated successfully'
            ]);

        } catch (\Exception $e) {
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_update',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => false,
                'details' => 'Failed to update vault item: ' . $id
            ]);

            return response()->json([
                'error' => 'Failed to update vault item',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        try {
            $vault = Vault::where('user_id', $request->user()->id)
                         ->findOrFail($id);

            $vault->delete();

            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_delete',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => true,
                'details' => 'Deleted vault item: ' . $id
            ]);

            return response()->json([
                'message' => 'Vault item deleted successfully'
            ]);

        } catch (\Exception $e) {
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_delete',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => false,
                'details' => 'Failed to delete vault item: ' . $id
            ]);

            return response()->json([
                'error' => 'Failed to delete vault item',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function getByCategory(Request $request, string $category): JsonResponse
    {
        try {
            $vaults = Vault::where('user_id', $request->user()->id)
                          ->where('category', $category)
                          ->get(['id', 'data_hash', 'created_at', 'last_accessed_at']);

            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_category_access',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => true,
                'details' => 'Accessed vault category: ' . $category
            ]);

            return response()->json([
                'vaults' => $vaults,
                'category' => $category,
                'count' => $vaults->count()
            ]);

        } catch (\Exception $e) {
            AccessLog::create([
                'user_id' => $request->user()->id,
                'action' => 'vault_category_access',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => false,
                'details' => 'Failed to access vault category: ' . $category
            ]);

            return response()->json([
                'error' => 'Failed to fetch vault items for category',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}