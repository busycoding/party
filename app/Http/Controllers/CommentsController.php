<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentStoreRequest;
use App\Comment;
use App\Company;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store(Company $company, CommentStoreRequest $request) //CommentStoreRequest $request // Request $request
    {
/*    	if (Auth::check()) {
    		echo '1';
    	} else {
    		echo '2';
    	}*/
    	$data = $request->all();
    	$data['company_id'] = $company->id;
    	$data['user_id'] = Auth::id();
    	//dd($request->user()->id);
    	//dd(Auth::user());
    	//$id = Auth::id();
    	//dd($data);
    	// $company->comments()->create($request->all());
    	Comment::create($data);
        //$company->createComment($request->all());

        return redirect()->back()->with('message', "Your comment successfully sent.");
    }
}
