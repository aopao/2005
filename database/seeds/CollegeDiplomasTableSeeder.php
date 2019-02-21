<?php

use Illuminate\Database\Seeder;
use App\Entities\CollegeDiplomas;
use App\Services\JsonToArrayService;

class CollegeDiplomasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new CollegeDiplomas();
        $data = JsonToArrayService::getJson('college_diplomases.json');
        foreach ($data as $value) {
            $model->insert($value);
        }
    }
}
