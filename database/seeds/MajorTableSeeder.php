<?php

use App\Entities\Major;
use Illuminate\Database\Seeder;
use App\Services\JsonToArrayService;

class MajorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Major();
        $data = JsonToArrayService::getJson('majors.json');
        foreach ($data as $value) {
            $model->insert($value);
        }
    }
}
