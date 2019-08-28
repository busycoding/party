<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;

class UsersController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users      = User::orderBy('name')->paginate($this->limit);
        $usersCount = User::count();

        return view("admin.users.index", compact('users', 'usersCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $roles = Role::orderBy('name')->pluck('display_name', 'id');
        $user_role_id = "";

        return view("admin.users.create", compact('user', 'roles', 'user_role_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\UserStoreRequest $request)
    {
        // $data = $request->all();
        // $data['password'] = bcrypt($data['password']);
        // $user = User::create($data);
        // $user->attachRole($request->role_id);
        
        $user = User::create($request->all());
        $user->attachRole($request->role);

        return redirect("/admin/users")->with("message", "New user was created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name')->pluck('display_name', 'id');
        $user_role_id = $user->roles->first()->id;

        return view("admin.users.edit", compact('user', 'roles', 'user_role_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //Requests\UserUpdateRequest
    {

//https://stackoverflow.com/questions/53756328/how-to-update-only-one-input-in-laravel-form
        $this->validate($request, [
            'name'     => 'required|max:255',
            'email'    => 'email|required|max:255|unique:users,email,' . $id,
            'role'     => 'required',
            'slug'     => 'required|unique:users'
        ]);

        $name  = $request->name;
        $email = $request->email;
        $role  = $request->role;
        $slug  = $request->slug;
        $bio   = $request->bio;

        // User::findOrFail($id)->update($request->all());
        $user = User::findOrFail($id);
        $user->update(['name' => $name, 'email' => $email, 'role' => $role, 'slug' => $slug, 'bio' => $bio]);

        // $user->role
        $user->detachRoles();
        $user->attachRole($request->role);

        // $q = User::where('id','=',auth()->user()->id);
        // $q->update(['name'=>$name,'email'=>$email]);

        if(isset($request->password)){
            $this->validate($request,[
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required_with:password|same:password'
            ]);

            $password = $request->password;
            $user->update(['password' => $password ]);
        }

        return redirect("/admin/users")->with("message", "User was updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests\UserDestroyRequest $request, $id)
    {
        // $user = User::findOrFail($id);
        // $user->delete();

        // return redirect("/admin/users")->with("message", "User was deleted successfully!");
        $user = User::findOrFail($id);

        $deleteOption = $request->delete_option;
        $selectedUser = $request->selected_user;
        // TODO: test this functionality
        if ($deleteOption == "delete") {
            // TODO: delete users image
            // delete user posts
            $user->companies()->withTrashed()->forceDelete();
        }
        elseif ($deleteOption == "attribute") {
            $user->companies()->update(['user_id' => $selectedUser]);
        }

        $user->delete();

        return redirect("/admin/users")->with("message", "User was deleted successfully!");
    }

    public function confirm(Requests\UserDestroyRequest $request, $id)
    {
        $user = User::findOrFail($id);
        // get all users except the one that will be removed
        $users = User::where('id', '!=', $user->id)->pluck('name', 'id')->all(); //User::where('id', '!=', $user->id)->get(); - using this, just diplay it as  @foreach ($users as $u) & <option value="{{$u->id}}">{{$u->name}}</option>

        return view("admin.users.confirm", compact('user', 'users'));
    }
}