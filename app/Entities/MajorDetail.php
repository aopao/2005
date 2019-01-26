<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MajorDetail.
 *
 * @package namespace App\Entities;
 */
class MajorDetail extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'major_id',
        'clicks',
        'awarded_degree',
        'job_direction',
        'graduation_student_num',
        'work_rate',
        'wen_ratio',
        'li_ratio',
        'male_ratio',
        'female_ratio',
        'zh_ratio',
        'bxtj_ratio',
        'jxzl_ratio',
        'jy_ratio',
        'description',
        'goal',
        'require',
        'obtain',
        'subject',
        'course',
        'teach',
        'year',
        'degree',
        'jobs',
        'male_trait',
        'female_trait',
        'employment_type',
        'employment_city',
        'money',
    ];

    //protected $casts = [
    //    'work_rate' => 'Array',
    //    'subject_rate' => 'Array',
    //    'gender_rate' => 'Array',
    //];
}
