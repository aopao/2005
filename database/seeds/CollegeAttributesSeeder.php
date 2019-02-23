<?php

use App\Entities\CollegeAttribute;
use Illuminate\Database\Seeder;

class CollegeAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => '211'],
            ['id' => 2, 'name' => '985'],
            ['id' => 3, 'name' => '直属中央'],
            ['id' => 4, 'name' => '直属教育部'],
            ['id' => 5, 'name' => '研究生院'],
            ['id' => 6, 'name' => '博士生院'],
            ['id' => 7, 'name' => '千人计划'],
            ['id' => 8, 'name' => '卓越计划'],
            ['id' => 9, 'name' => '自主招生'],
        ];
        foreach ($data as $value) {
            CollegeAttribute::create($value);
        }
    }
}
