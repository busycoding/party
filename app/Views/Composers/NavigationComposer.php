<?php
namespace App\Views\Composers;

use Illuminate\View\View;
use App\Category;
use App\Company;
use App\Tag;

class NavigationComposer
{
    public function compose(View $view)
    {
        $this->composeCategories($view);

        $this->composeTags($view);

        $this->composePopularCompanies($view);

        $this->composeArchives($view);
    }

    private function composeCategories(View $view)
    {
        $categories = Category::with(['companies' => function ($query){
            $query->approved();
        }])->orderBy('title', 'asc')->get();

        $view->with('categories', $categories);
    }

    private function composeTags(View $view)
    {
        $tags = Tag::has('companies')->get(); //->all();
        $view->with('tags', $tags);
    }

    private function composeArchives(View $view)
    {
        $archives = Company::archives();

        $view->with('archives', $archives);
    }

    private function composePopularCompanies(View $view)
    {
        $popularCompanies = Company::approved()->popular()->take(3)->get();
        $view->with('popularCompanies', $popularCompanies);
    }
}