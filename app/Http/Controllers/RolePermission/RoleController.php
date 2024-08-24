<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function createRole(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        // Create a new role
        $role = Role::create(['name' => $validated['name']]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully!',
            'role' => $role,
        ], 201);
    }

    public function getRoles()
    {
        $roles = Role::all();

        return response()->json([
            'success' => true,
            'message' => 'Roles retrived successfully!',
            'roles' => $roles,
        ]);
    }
}
