<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use DB;
class RoleController extends Controller
{
    public function index(){

        // return Role::with('users')->get();
        return view('roles.index',[

            'roles' => Role::all()
        ]);
    }

    public function create(){

        return view('roles.create',[

            'permissions' => permission::all()

        ]);

    }

    public function store(Request $request){

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        $permissions = $request->except(['name','_token']);

        foreach ($permissions as $key => $value) {

            $role->attachPermission($key);

        }
        return redirect('role')->with('success','Role Created Successfully.');

    }

    public function edit($id){

        return view('roles.edit',[

            'role' => Role::find($id),
            'permissions' => Permission::all()
        ]);

    }

    public function update(Request $request,$id){

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        DB::table('permission_role')->where('role_id',$id)->delete();

        $permissions = $request->except(['name','_token','_method']);

        foreach ($permissions as $key => $value) {

        $role->attachPermission($key);

        }
        return redirect('role')->with('success','Role Updated Successfully.');

    }

    public function destroy($id){

        return Role::destroy($id);


    }
}
