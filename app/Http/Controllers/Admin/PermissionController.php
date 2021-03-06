<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Permission;

class PermissionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions      = Permission::orderBy('name')->paginate($this->limit);
        $permissionsCount = Permission::count();

        return view("admin.permissions.index", compact('permissions', 'permissionsCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = new Permission();
        return view("admin.permissions.create", compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      if ($request->permission_type == 'basic') {
        $this->validateWith([
          'display_name' => 'required|max:255',
          'name' => 'required|max:255|alphadash|unique:permissions,name',
          'description' => 'sometimes|max:255'
        ]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        // Session::flash('success', 'Permission has been successfully added');
        // return redirect()->route('permissions.index');
        return redirect("/admin/permissions")->with("message", "New permission was created successfully!");

      } elseif ($request->permission_type == 'crud') {
        $this->validateWith([
          'resource' => 'required|min:3|max:100|alpha'
        ]);

        $crud = explode(',', $request->crud_selected);
        if (count($crud) > 0) {
          foreach ($crud as $x) {
            $slug = strtolower($x) . '-' . strtolower($request->resource);
            $display_name = ucwords($x . " " . $request->resource);
            $description = "Allows a user to " . strtoupper($x) . ' a ' . ucwords($request->resource);

            $permission = new Permission();
            $permission->name = $slug;
            $permission->display_name = $display_name;
            $permission->description = $description;
            $permission->save();
          }
          // Session::flash('success', 'Permissions were all successfully added');
          // return redirect()->route('permissions.index');
          return redirect("/admin/permissions")->with("message", "New permissions was created successfully!");
        }
      } else {
        return redirect()->route('permissions.create')->withInput();
      }
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
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.edit')->withPermission($permission);
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
            'name' => 'required|max:255',
            'display_name' => 'required|max:255',
            'description' => 'sometimes|max:255'
        ]);

        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        return redirect("/admin/permissions")->with("message", "Permission was updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect("/admin/permissions")->with("message", "Permission was deleted successfully!");
    }
}
