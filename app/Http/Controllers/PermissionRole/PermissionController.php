<?php

namespace App\Http\Controllers\PermissionRole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),

            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:create permission', only: ['create', 'store']),
            new Middleware('permission:edit permissions', only: ['edit', 'update']),
            new Middleware('permission:delete permission', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission = Permission::all();
        return view('admin.usermanagment.permisssion.viewpermission', compact('permission'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usermanagment.permisssion.createpermission');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|string|max:255',
        ]);

        try {
            Permission::create([
                'name' => $request->permission_name,
            ]);

            return response()->json([
                'message' => 'Permission created successfully',
            ], 201);
        } catch (PermissionAlreadyExists $e) {
            return response()->json([
                'message' => 'Permission already exists!',
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)

    {
        $permission = Permission::findorFail($id);
        return view('admin.usermanagment.permisssion.editpermission', compact('permission'));
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'permission_name' => 'required|string|max:255',
        ]);

        try {
            // Check if another permission with same name exists
            $exists = Permission::where('name', $request->permission_name)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Permission already exists!',
                ], 409);
            }

            $permission = Permission::findOrFail($id);

            $permission->update([
                'name' => $request->permission_name,
            ]);

            return response()->json([
                'message' => 'Permission updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findorFail($id);
        $permission->delete();
        return response()->json(['message' => 'permission deleted successfully.']);
    }
}
