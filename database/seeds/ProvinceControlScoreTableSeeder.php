<?php

use Illuminate\Database\Seeder;
use App\Services\JsonToArrayService;
use App\Entities\ProvinceControlScore;

class ProvinceControlScoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new ProvinceControlScore();
        $data = JsonToArrayService::getJson('province_control_scores.json');
        foreach ($data as $value) {
            $model->insert($value);
        }
    }
}
