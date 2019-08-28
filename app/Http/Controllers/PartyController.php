<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Company;
use App\Category;
use App\User;
use App\Tag;

class PartyController extends Controller
{
    // We are using config/ComposerServiceProvider to get the categories to the view
	protected $limit = 3;

    public function index(){

    	// Display what was being selected, shows how we are doing a query for each entry, so 10 entries, 10 queries, so we will use with below
/*    	\DB::enableQueryLog();
    	$companies = Company::all();
    	// compact creates a result with the variable
    	view('party.index', compact('companies'))->render();
    	dd(\DB::getQueryLog());
*/
    	// so we have a query for the companies and then we have a new select for users for each of the companies, where in the next one, we bundle all users_id's in a 'in' part of a query
    	/*$companies = Company::all();
    	// compact creates a result with the variable
    	return view('party.index', compact('companies'));*/

    	// So here we get all the companies and then users using a 'in (1,2,3)' in the query
    	// '->orderBy('created_at', 'desc')' or laravels 'latest()' or 'latestFirst()' scope - which we define in app/Company.php
    	//$companies = Company::with('user')->latestFirst()->get();
    	// instead of get all, we can limit the amount to display. We can just use 'simplePagination(3)' to only show a left and right arrows for next or prev page
        
        // Video 58 debug 4:50
    	$companies = Company::with('user', 'tags', 'category', 'comments') // we had 13 queries, once we added , 'tags', 'category' it decreased by 8
    	                 ->latestFirst()
    	                 ->approved()
                         // Company Modal scopeFilter
                         //->filter(request('term'))
                         ->filter(request()->only(['term', 'year', 'month']))
    	                 ->paginate($this->limit);

        // We removed this and added filter(request('term')), but inside filter, inside the function, it adds an OR inside the bracket
        //->orWhere('title', 'LIKE', "%{$term}%");
        //->orWhere('description', 'LIKE', "%{$term}%");

        // added with('companies') so we don't have to have a lot of the same queries
        //\DB::enableQueryLog();
        //$categories = Category::orderBy('title', 'asc')->get();
/*        $categories = Category::with(['companies' => function ($query){
            // $query->where('approved', '=', true)
            $query->approved();
        }])->orderBy('title', 'asc')->get();*/
        //dd(\DB::getQueryLog());

    	// compact creates a result with the variable
        // removed , 'categories'
    	return view('party.index', compact('companies'));
    }

    // public function show($id) {
    // $company = Company::findOrFail($id);
    // you can make it more compact to inject a module to a paramater like 'Company $company'
    //public function show(Company $company) {
   	//return view("party.show", compact('company'));
    public function show(Company $company) { //$id
    	// added approved()-> so that only the approved ones will show, now we get a 404 page if not approved
    	// $company = Company::approved()->findOrFail($id);


      // update companies set view_count = view_count + 1 where id = ?
      // Need protected $fillable = ['view_count']; inside Company.php model
      // $viewCount = $company->view_count + 1;
      // $company->update(['view_count' => $viewCount]);
      $company->increment('view_count');
//dd(Company::with('comments')::with('user')->get());
//$company->comments()->with('user')
      //dd($company->comments()->with('user')->paginate(3)->toSql());
      // had to add user function to comments model
      $companyComments = $company->comments()->with('user')->paginate(3);

    	return view("party.show", compact('company', 'companyComments'));
    }
    // we did have $id but now added 'Category $category' to do route model id so we bind to the id
    public function category(Category $category){

        $categoryName = $category->title;
        //\DB::enableQueryLog();
       /* $companies = Company::with('user')
                         ->latestFirst()
                         ->approved()
                         ->where('category_id', $id)
                         ->paginate($this->limit);*/

        // We are going to try to use the slug 
        // if we don't have with('user') we will end up getting 10 queries if we have 10 posts
        // we had 'Category::find($id)' then replaced it with '$category' for binding route model by id
        $companies = $category->companies()
                              ->with('category', 'tags', 'comments')
                              ->latestFirst()
                              ->approved()
                              ->paginate($this->limit);

        return view('party.index', compact('companies', 'categoryName'));
    }

    public function tag(Tag $tag)
    {
        $tagName = $tag->title;

        $companies = $tag->companies()
                          ->with('user', 'category', 'comments') // , 'category', 'comments'
                          ->latestFirst()
                          ->approved()
                          ->paginate($this->limit);

         return view("party.index", compact('companies', 'tagName'));
    }

    public function user(User $user){
        $userName = $user->name;

        $companies = $user->companies()
                              ->with('category', 'tags', 'comments')
                              ->latestFirst()
                              ->approved()
                              ->paginate($this->limit);

        return view('party.index', compact('companies', 'userName'));
    }
}
