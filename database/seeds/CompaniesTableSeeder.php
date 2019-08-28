<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // reset the companies table
        DB::table('companies')->truncate();

        // generate 10 dummy companies data
        $companies = [];
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++)
        {
            $image = "Post_Image_" . rand(1, 5) . ".jpg";
            $date = date("Y-m-d H:i:s", strtotime("2018-07-18 08:00:00 +{$i} days"));


            $companies[] = [
                'user_id' => rand(1, 3),
                'title' => $faker->sentence(rand(8, 12)),
                'description' => $faker->text(rand(250, 300)),
                //'body' => $faker->paragraphs(rand(10, 15), true),
                'slug' => $faker->slug(),
                'image' => rand(0, 1) == 1 ? $image : NULL,
                'approved' => 1,
                'view_count' => rand(1, 10),
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        DB::table('companies')->insert($companies);
    }
}
