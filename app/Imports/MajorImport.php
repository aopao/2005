<?php

namespace App\Imports;

use App\Entities\Major;
use App\Entities\MajorDetail;
use Maatwebsite\Excel\Concerns\ToModel;

class MajorImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        dd('已经导入啦!');
        if ($row[0] != "门类") {
            $diplomas = $row[4] == "专科" ? 0 : 1;
            $res = Major::where('name', $row[2])->where('diplomas', $diplomas)->first();
            if (isset($res['id'])) {
                $data = [
                    'major_id' => $res['id'],
                    'clicks' => rand(50, 23045),
                    'awarded_degree' => $row[6] == "-" ? "" : $row[6],
                    'job_direction' => $row[24] == "-" ? "" : $row[24],
                    'graduation_student_num' => $row[26] == "-" ? "" : $row[26],
                    'work_rate' => $row[27] == "-" ? "" : $row[27],
                    'wen_ratio' => $row[16] == "-" ? "" : $row[16],
                    'li_ratio' => $row[17] == "-" ? "" : $row[17],
                    'zh_ratio' => $row[20] == "-" ? "" : $row[20],
                    'bxtj_ratio' => $row[21] == "-" ? "" : $row[21],
                    'jxzl_ratio' => $row[22] == "-" ? "" : $row[22],
                    'jy_ratio' => $row[23] == "-" ? "" : $row[23],
                    'male_ratio' => $row[18] == "-" ? "" : $row[18],
                    'female_ratio' => $row[19] == "-" ? "" : $row[19],
                    'description' => $row[15] == "暂无" ? "" : $row[15],
                    'goal' => $row[12] == "暂无" ? "" : $row[12],
                    'require' => $row[13] == "暂无" ? "" : $row[13],
                    'obtain' => $row[11] == "暂无" ? "" : $row[11],
                    'subject' => $row[10] == "暂无" ? "" : $row[10],
                    'course' => $row[9] == "暂无" ? "" : $row[9],
                    'teach' => $row[14] == "暂无" ? "" : $row[14],
                    'year' => $row[5] == "暂无" ? "" : $row[5],
                    'degree' => $row[7] == "暂无" ? "" : $row[7],
                    'jobs' => $row[30] == "暂无" ? "" : $row[30],
                    'male_trait' => $row[18] == "-" ? "" : $row[18],
                    'female_trait' => $row[19] == "-" ? "" : $row[19],
                    'employment_type' => $row[29] == "-" ? "" : $row[29],
                    'employment_city' => $row[28] == "-" ? "" : $row[28],
                    'money' => '',
                ];
                echo "<pre>";
                print_r($data);
                echo "</pre>";
                MajorDetail::create($data);
            }
        }

        //return new Major([
        //    //
        //]);
    }
}
