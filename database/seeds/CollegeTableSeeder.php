<?php

use App\Entities\College;
use Illuminate\Database\Seeder;
use App\Services\JsonToArrayService;

class CollegeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new College();
        $data = JsonToArrayService::getJson('colleges.json');
        foreach ($data as $value) {
            $model->insert($value);
        }
    }
}
