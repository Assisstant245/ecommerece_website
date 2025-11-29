<?php

namespace App\Http\Controllers\PermissionRole;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:user view', only: ['index']),
            new Middleware('permission:user create', only: ['create', 'store']),
            new Middleware('permission:edit user', only: ['edit', 'update']),
            new Middleware('permission:delete user', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $user = User::all();
        return view('admin.usermanagment.viewuser', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.usermanagment.createuser', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => 'adminuser',
            'first_name' => $request->first_name,
            'last_name' => $request->first_name,
            'mobile_no' => $request->mobile_no,


        ]);
        $user->syncRoles($request->roles);

        return response()->json([
            'message' => 'User created with roles and permissions successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user    = User::findorFail($id);
        $roles = Role::all();
        return view('admin.usermanagment.edituser', compact('roles', 'user'));
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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // 2. Find the user
        $user = User::findOrFail($id);

        // 3. Update name and email
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile_no = $request->mobile_no;
        $user->email = $request->email;

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        // 4. Sync Roles
        $user->syncRoles($request->roles);


        return response()->json(['message' => 'User updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::findorFail($id);
        $user->delete();
        return response()->json(['message' => 'user deleted successfully.']);
    }
}
