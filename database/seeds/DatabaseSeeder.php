<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(AdminTableSeeder::class);
        //$this->call(RoleTableSeeder::class);
        //$this->call(CollegeSeeder::class);
        //$this->call(CollegeDetailSeeder::class);
        //$this->call(CollegeCategorySeeder::class);
        //$this->call(CollegeDiplomasSeeder::class);
        //$this->call(MajorSeeder::class);
        //$this->call(MajorDetailSeeder::class);
        //$this->call(ProvinceControlScoreSeeder::class);
        $this->call(CollegeAttributesSeeder::class);
    }
}
