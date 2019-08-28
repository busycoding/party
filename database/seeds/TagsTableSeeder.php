<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\Company;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->truncate();

        $clown = new Tag();
        $clown->name = "Clown";
        $clown->slug = "clown";
        $clown->save();

        $music = new Tag();
        $music->name = "Music";
        $music->slug = "music";
        $music->save();

        $dance = new Tag();
        $dance->name = "Dance";
        $dance->slug = "dance";
        $dance->save();

        $toddlers = new Tag();
        $toddlers->name = "Toddlers";
        $toddlers->slug = "toddlers";
        $toddlers->save();

        // Randomly add tags to posts, TODO: remove this on launch
        $tags = [
            $clown->id,
            $music->id,
            $dance->id,
            $toddlers->id
        ];

        foreach (Company::all() as $company)
        {
            shuffle($tags);
            
            for ($i = 0; $i < rand(0, count($tags)-1); $i++)
            {
                $company->tags()->detach($tags[$i]);
                $company->tags()->attach($tags[$i]);
            }
        }
    }
}
