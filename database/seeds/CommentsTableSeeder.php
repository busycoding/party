<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Company;
use App\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker    = Factory::create();
        $comments = [];

        $companies = Company::approved()->latest()->take(5)->get();
        foreach ($companies as $company)
        {
            for ($i = 1; $i <= rand(1, 10); $i++)
            {
                $commentDate = $company->created_at->modify("+{$i} hours");

                $comments[] = [
                    'user_name' => $faker->name,
                    'user_email' => $faker->email,
                    'user_url' => $faker->domainName,
                    'body' => $faker->paragraphs(rand(1, 5), true),
                    'company_id' => $company->id,
                    'created_at' => $commentDate,
                    'updated_at' => $commentDate,
                ];
            }
        }

        Comment::truncate();
        Comment::insert($comments);
    }
}
