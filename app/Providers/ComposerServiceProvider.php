<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Views\Composers\NavigationComposer;
//use App\Category;
//use App\Company;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.sidebar', NavigationComposer::class);
        // view()->composer('layouts.sidebar', function($view) {
        //     $categories = Category::with(['companies' => function ($query){
        //         $query->approved();
        //     }])->orderBy('title', 'asc')->get();

        //     return $view->with('categories', $categories);
        // });

        // view()->composer('layouts.sidebar', function($view) {
        //     $popularCompanies = Company::approved()->popular()->take(3)->get();

        //     return $view->with('popularCompanies', $popularCompanies);
        // });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
