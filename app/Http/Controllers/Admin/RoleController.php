<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Role;
use App\Permission;

class RoleController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles      = Role::orderBy('name')->paginate($this->limit);
        $rolesCount = Role::count();

        return view("admin.roles.index", compact('roles', 'rolesCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        $role = new Role();
        return view('admin.roles.create', compact('permissions', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validateWith([
            'name' => 'required|max:100|alpha_dash|unique:roles,name',
            'display_name' => 'required|max:255',
            'description' => 'sometimes|max:255'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        //https://stackoverflow.com/questions/49548698/difference-between-syncpermissions-and-attachpermissions
        if ($request->permissions) {
            $role->syncPermissions(explode(',', $request->permissions));
        }

        return redirect("/admin/roles")->with("message", "Role was updated successfully!");
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
        // find or fail will not work here: https://youtu.be/e7AeTjNiQg0?t=1088
        $role = Role::where('id', $id)->with('permissions')->first();
        $permissions = Permission::all();
        return view('admin.roles.edit')->withRole($role)->withPermissions($permissions);


/*$permissions= Permission::all()->pluck('id')->toArray();

In the edit view add:
<input 
      type="checkbox" class="custom-control-input" 
      name="permission_type" 
      id="{{$permission->id}}" 
      value="{{$permission->id}}" {{in_array($permission->id,$permissions)?'checked':''}}>*/


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateWith([
            'name' => 'required|max:100|alpha_dash|unique:roles,name',
            'display_name' => 'required|max:255',
            'description' => 'sometimes|max:255'
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        //https://stackoverflow.com/questions/49548698/difference-between-syncpermissions-and-attachpermissions
        if ($request->permissions) {
            $role->syncPermissions(explode(',', $request->permissions));
        }

        // Session::flash('success', 'Successfully update the '. $role->display_name . ' role in the database.');
        // return redirect()->route('roles.show', $id);
        return redirect("/admin/roles")->with("message", "Role was updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
