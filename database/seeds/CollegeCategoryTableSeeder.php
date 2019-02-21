<?php

use Illuminate\Database\Seeder;
use App\Entities\CollegeCategory;
use App\Services\JsonToArrayService;

class CollegeCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new CollegeCategory();
        $data = JsonToArrayService::getJson('college_categories.json');
        foreach ($data as $value) {
            $model->insert($value);
        }
    }
}
