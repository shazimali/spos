<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use App\Role;
use DB;
use Auth;
class UserController extends Controller
{
    public function index(){

        return view('users.index',[

            'users' => User::all()
        ]);
    }

    public function create(){

        return view('users.create',[

            'roles' => Role::all()
        ]);
    }

    public function store(UserRequest $request){

        $credentials = [

            'name'=> $request->name,
            'email'=> $request->email,
            'password'=>bcrypt($request->password),
        ];

        $user = User::create($credentials);
        $user->attachRole($request->role);

        return redirect('user')->with('success','User created successfully.');
    }

    public function edit($id){

        return view('users.edit',[

            'user'=> User::find($id),
            'roles' => Role::all(),
        ]);

    }

    public function update(UserUpdateRequest $request,$id){


        $user = User::find($id);

        $user->name = $request->name;

        DB::table('role_user')->where('user_id', $id)->delete();

        $user->attachRole($request->role);

        if($request->password){

            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect('user')->with('success','User updated successfully.');


    }

    public function destroy($id){

       return  User::destroy($id);

    }
}
