<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    //Get the user's details
    public function userShow(User $user){

        return view('admin.users.show', ['user' =>$user]);

    }

    public function setrole(Request $request){

        $validated = $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $role = Role::findOrFail($validated['role_id']);
        $user = User::findOrFail($validated['user_id']);

        $changes = $user->roles()->syncWithoutDetaching([
            $role->id => [
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        if (empty($changes['attached'])) {
            return back()->with('success', "User $user->name already has the $role->role role");
        }

        return back()->with('success', "Role $role->role granted to user $user->name successfully");
    }

    public function removerole(Request $request){

        $role = Role::find($request->input('role_id'));
        $user = User::find($request->input('user_id'));

        try{
            $user->roles()->detach($role->id);
            return back()->with('success', "Role $role->role removed from $user->name");
        }catch(QueryException $e){
            return back()->withErrors("Role $role->role could not be removed from $user->name");
        }
    }
}
