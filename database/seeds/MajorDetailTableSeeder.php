<?php

use App\Entities\MajorDetail;
use Illuminate\Database\Seeder;
use App\Services\JsonToArrayService;

class MajorDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new MajorDetail();
        $data = JsonToArrayService::getJson('major_details.json');
        foreach ($data as $value) {
            $model->insert($value);
        }
    }
}
