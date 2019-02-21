<?php

namespace App\Imports;

use App\Entities\Province;
use App\Entities\ProvinceControlScore;
use Maatwebsite\Excel\Concerns\ToModel;

class ProvinceControlScoreImport implements ToModel
{
    /**
     * 批量导入省控线方法
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null|void
     */
    public function model(array $row)
    {
        if ($row[0] != "省份") {
            switch ($row[3]) {
                case '文科':
                    $diplomas = 0;
                    break;
                case '理科';
                    $diplomas = 1;
                    break;
                case '不分文理':
                    $diplomas = 2;
                    break;
                default:
                    $diplomas = 0;
            }
            $province = Province::where('name', 'like', '%'.$row[0].'%')->first();

            $data = [
                'province_id' => $province['id'],
                'year' => $row[1] == "-" ? "" : $row[1],
                'batch' => $row[2] == "-" ? "" : $row[2],
                'subject' => $diplomas,
                'score' => $row[4] == "-" ? "" : $row[4],
            ];
            ProvinceControlScore::create($data);
        }
    }
}
