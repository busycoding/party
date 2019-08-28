<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends AdminController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home.index');
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        return view('admin.home.edit', compact('user'));
    }

    public function update(Requests\AccountUpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->all());

        return redirect()->back()->with("message", "Account was update successfully!");
    }
}
