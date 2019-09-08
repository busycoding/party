<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Company;
use App\Category;
use Intervention\Image\Facades\Image;

class PartyController extends AdminController
{
    protected $uploadPath;

    public function __construct()
    {
        // call parent constructor so we don't lose the middleware calling
        parent::__construct();
        $this->uploadPath = public_path(config('cms.image.directory'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $onlyTrashed = FALSE;

        if (($status = $request->get('status')) && $status == 'trash')
        {
            $companies       = Company::onlyTrashed()->with('category', 'user')->latest()->paginate($this->limit);
            $companiesCount   = Company::onlyTrashed()->count();
            $onlyTrashed = TRUE;
        }
        elseif ($status == 'published')
        {
            //$posts       = Post::published()->with('category', 'author')->latest()->paginate($this->limit);
            //$postCount   = Post::published()->count();
        }
        elseif ($status == 'scheduled')
        {
            //$posts       = Post::scheduled()->with('category', 'author')->latest()->paginate($this->limit);
            //$postCount   = Post::scheduled()->count();
        }
        elseif ($status == 'draft')
        {
            //$posts       = Post::draft()->with('category', 'author')->latest()->paginate($this->limit);
            //$postCount   = Post::draft()->count();
        }
        elseif ($status == 'own')
        {
            $companies       = $request->user()->companies()->with('category', 'user')->latest()->paginate($this->limit);
            $companiesCount   = $request->user()->companies()->count();
        }
        else
        {
            $companies = Company::latest()->with('category', 'user')->paginate($this->limit);
            //$companies = Company::all();
            $companiesCount = Company::count();
        }

        $statusList = $this->statusList($request);
     
        return view('admin.party.index', compact('companies', 'companiesCount', 'onlyTrashed', 'statusList'));
    }

    private function statusList($request)
    {
        return [
            'own'       => auth()->user()->companies()->count(),//auth()->user()->companies()->count(),
            'all'       => Company::count(),
            //'published' => Post::published()->count(),
            //'scheduled' => Post::scheduled()->count(),
            //'draft'     => Post::draft()->count(),
            'trash'     => Company::onlyTrashed()->count(),
        ];
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        //dd('create');
        // Same as doing 'Company $company' in the parameters
        //$company = new Company();
        $categories = Category::orderBy('title', 'asc')->get();//->pluck('title', 'id');

        $tags = [];

        //$categories->prepend('Please Select', '');
        return view('admin.party.create', compact('company', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\PartyRequest $request) //Request $request
    {
        // moved to PartyRequest.php
/*        $this->validate($request, [
            'title'        => 'required',
            'slug'         => 'required|unique:companies',
            'description'  => 'required',
            'category_id'  => 'required'
        ]);*/
        // since each company belongs to a user, take current user with the reletionship of companies method
        // TODO: look for duplicate filenames for image
        $data = $this->handleRequest($request);

        $newCompany = $request->user()->companies()->create($data);

        $newCompany->createTags($data["tags"]);
//https://laracasts.com/discuss/channels/eloquent/eloquent-attach-method-for-multiple-inserts-into-a-pivot-table
// try
// {
//     $repository->createJob($request->except('tags'));
//     $repository->createTags($request->input('tags'));
//     $repository->save();
// }
// catch (FailedJobCreateException $e)
// {
//     return Redirect::back()
//         ->withErrors($e->getErrors())
//         ->withInput($request->all());
// }



        //$request->user()->companies()->create($request->all());
        // you can use the route function redirect(route('admin.blog'))
        return redirect('/admin/party')->with('message', 'Your company was created successfully!');
/*
        return redirect('/backend/blog')->with('message', 'Your company was created successfully!');*/
//        dd('store');
    }

    private function handleRequest($request)
    {
        $data = $request->all();

        if ($request->hasFile('image'))
        {
            $image       = $request->file('image');
            $fileName    = $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = $image->move($destination, $fileName);

            if ($successUploaded)
            {
                $width     = config('cms.image.thumbnail.width');
                $height    = config('cms.image.thumbnail.height');
                $extension = $image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                Image::make($destination . '/' . $fileName)
                    ->resize($width, $height)
                    ->save($destination . '/' . $thumbnail);
            }

            $data['image'] = $fileName;
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $categories = Category::orderBy('title', 'asc')->get();

        $tags = $company->tags->pluck('name');

        return view("admin.party.edit", compact('company', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\PartyRequest $request, $id) //Request $request
    {
        $company  = Company::findOrFail($id);
        $oldImage = $company->image;
        $data     = $this->handleRequest($request);

        $company->update($data);
        $company->createTags($data['tags']);
        
        if ($oldImage !== $company->image) {
            $this->removeImage($oldImage);
        }
        return redirect('/admin/party')->with('message', 'Your company was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::findOrFail($id)->delete();

        return redirect('/admin/party')->with('trash-message', ['Your company moved to Trash', $id]);
    }

   public function forceDestroy($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->forceDelete();

        $this->removeImage($company->image);

        return redirect('/admin/party?status=trash')->with('message', 'Your company has been deleted successfully');
    }

    public function restore($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();

        return redirect()->back()->with('message', 'Your post has been restored from the Trash');
    }

    private function removeImage($image)
    {
        if ( ! empty($image) )
        {
            $imagePath     = $this->uploadPath . '/' . $image;
            $ext           = substr(strrchr($image, '.'), 1);
            $thumbnail     = str_replace(".{$ext}", "_thumb.{$ext}", $image);
            $thumbnailPath = $this->uploadPath . '/' . $thumbnail;

            if ( file_exists($imagePath) ) unlink($imagePath);
            if ( file_exists($thumbnailPath) ) unlink($thumbnailPath);
        }
    }
}
