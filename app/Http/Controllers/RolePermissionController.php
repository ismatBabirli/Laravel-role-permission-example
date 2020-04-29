<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function createRole(Request $request)
    {

//        dd($request->input("name"));
        $role = Role::create(['name' => $request->input("name")]);

        return response()->json($role, 200);
    }

    public function createPermission(Request $request)
    {

        $permission = Permission::create(['name' => $request->input("name")]);
        return response()->json($permission, 200);
    }


    public function getRoles()
    {
        $roles = Role::with("permissions")->get();
        return response()->json($roles, 200);
    }

    public function getPermissions()
    {
        $permissions = Permission::all();
        return response()->json($permissions, 200);
    }

    public function addPermissionsToRole(Request $request, $id)
    {
        $role = Role::findById($id);
        $role->syncPermissions($request->input("permissions"));
        return response()->json([], 200);
    }

    public function assignRoleToUser($role_id, $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->assignRole($role_id);
        return response()->json([], 200);
    }
}
