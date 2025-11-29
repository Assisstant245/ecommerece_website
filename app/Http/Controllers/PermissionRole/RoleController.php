<?php

namespace App\Http\Controllers\PermissionRole;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),

            new Middleware('permission:role view', only: ['index']),
            new Middleware('permission:role create', only: ['create', 'store']),
            new Middleware('permission:role edit', only: ['edit', 'update']),
            new Middleware('permission:role delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $roles = Role::all();
        return view('admin.usermanagment.roles.viewrole', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = Permission::all();

        return view('admin.usermanagment.roles.createrole', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'permissions' => 'nullable|array',

        ]);

        try {
            // Check if role already exists
            if (Role::where('name', $request->role_name)->exists()) {
                return response()->json([
                    'message' => 'Role already exists!',
                ], 409);
            }

            // Create role
            $role = Role::create([
                'name' => $request->role_name,
            ]);

            $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
            $role->syncPermissions($permissions);

            return response()->json([
                'message' => 'Role created successfully',
                'role' => $role->name
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roles    = Role::findorFail($id);
        $permission = Permission::all();
        return view('admin.usermanagment.roles.editrole', compact('roles', 'permission'));
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
    public function update(Request $request, $id)
    {

        try {
            // Manual check for duplicate name
            $exists = Role::where('name', $request->role_name)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Role with this name already exists!'
                ], 409);
            }

            // Validate permissions array if provided
            $request->validate([
                'role_name' => 'required|string|max:255|unique:roles,name,' . $id,

                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            // Find role and update
            $role = Role::findOrFail($id);
            $role->update(['name' => $request->role_name]);

            // Sync permissions
            $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
            $role->syncPermissions($permissions);

            return response()->json([
                'message' => 'Role updated successfully.',
                'role' => $role->name
            ], 200);

            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $roles = Role::findorFail($id);
        $roles->delete();
        return response()->json(['message' => 'role deleted successfully.']);
    }
}
