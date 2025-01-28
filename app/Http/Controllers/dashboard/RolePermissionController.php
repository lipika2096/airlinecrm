<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller {
    public function index() {
        $roles = Role::with('permissions')->where('name', '!=', 'SuperAdmin')->get();
        $permissions = Permission::all();
        return view( 'admin.roles-permissions', compact( 'roles', 'permissions' ) );
    }
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Create the role
        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web'
        ]);

        // Attach the permissions to the role
        $role->permissions()->attach($validated['permissions']);

        // You can use Toastr for a success message
        return redirect()->back()->with('success', 'Role created successfully.');
    }

    public function getRolePermissions( $id ) {
        $role = Role::findOrFail( $id );
        $permissions = Permission::all();

        return response()->json( [
            'permissions' => $permissions,
            'role_permissions' => $role->permissions->pluck( 'id' )->toArray(),
        ] );
    }

    public function update( Request $request ) {
        $request->validate( [
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
        ] );

        $role = Role::findOrFail( $request->role_id );

        // Get permission names from IDs
        $permissionNames = Permission::whereIn( 'id', $request->permissions )->pluck( 'name' )->toArray();

        // Sync permissions with names
        if ( $permissionNames ) {
            $role->syncPermissions( $permissionNames );
        } else {
            $role->permissions()->detach();
        }

        return redirect()->back()->with( 'success', 'Role updated successfully!' );
    }

}
