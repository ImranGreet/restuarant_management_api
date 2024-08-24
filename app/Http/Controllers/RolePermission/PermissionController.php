<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function createPermission(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Create a new role
        $permission = Permission::create(['name' => $validated['name']]);

        // Sync the permission with roles if provided
        if (!empty($validated['roles'])) {
            $roles = Role::whereIn('id', $validated['roles'])->get();
            foreach ($roles as $role) {
                $role->givePermissionTo($permission);
            }
        }


        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully!',
            'permission' => $permission,
        ], 201);
    }

    public function getPermissions()
    {
        $permissions = Permission::all();
        return response()->json([
            'success' => true,
            'message' => 'Permission retrived successfully!',
            'permission' => $permissions,
        ], 201);
    }
}
