<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use App\Company;

class TagController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags      = Tag::with('companies')->orderBy('name')->paginate($this->limit);
        $tagsCount = Tag::count();

        return view("admin.tags.index", compact('tags', 'tagsCount'));  // ->withTags($tags) would create tags variable
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // IF we don't need this, we need to put ['except' => 'create'] into our route resource
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array('name' => 'required|max:255'));
        $tag = new Tag;
        $tag->name = $request->name;
        $tag->name = str_replace(" ", "-", strtolower($request->name));
        $tag->save();

        return redirect("/admin/tags")->with("message", "New Tag was created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        $companies = $tag->companies()->paginate($this->limit);
        return view('admin.tags.show', compact('tag', 'companies'));
        //return view('admin.tags.show')->withTag($tag, $companies);

        // $tag      = Tag::with('companies')->paginate($this->limit);
        // $tagCount = Tag::count();

        // return view("admin.tags.show", compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('admin.tags.edit')->withTag($tag);
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
        $tag = Tag::find($id);

        $this->validate($request, ['name' => 'required|max:255']);

        $tag->name = $request->name;
        $tag->slug = $request->slug;
        $tag->save();

        //Session::flash('success', 'Successfully saved your new tag!');

        //return redirect()->route('tags.show', $tag->id)

        return redirect('/admin/tags')->with('message', 'Your tag was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        $tag->companies()->detach();

        $tag->delete();

        //Session::flash('success', 'Tag was deleted successfully');

        //return redirect()->route('tags.index');
        return redirect('/admin/tags')->with('message', 'Your tag was deleted successfully!');
    }
}
