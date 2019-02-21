<?php

use App\Entities\CollegeDetail;
use Illuminate\Database\Seeder;
use App\Services\JsonToArrayService;

class CollegeDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new CollegeDetail();
        $data = JsonToArrayService::getJson('college_details.json');
        foreach ($data as $value) {
            $model->insert($value);
        }
    }
}
