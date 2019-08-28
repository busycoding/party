<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert([
        	[
        		'title' => 'Uncategorized',
        		'slug' => 'uncategorized'
        	],
        	[
        		'title' => 'Characterchures',
        		'slug' => 'characterchures'
        	],
        	[
        		'title' => 'Superheroes',
        		'slug' => 'superheroes'
        	]
        ]);

        // update the company data
        for ($company_id = 1; $company_id <= 10; $company_id++)
        {
            $category_id = rand(1, 3);

            DB::table('companies')
                ->where('id', $company_id)
                ->update(['category_id' => $category_id]);
        }
    }
}
