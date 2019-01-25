<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class College.
 *
 * @package namespace App\Entities;
 */
class College extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * 设置数据库表
     *
     * @var string
     */
    protected $table = "colleges";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * 关联大学详情表
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function collegeDetail()
    {
        return $this->hasOne('App\Entities\CollegeDetail');
    }

    /**
     * 关联大学类型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collegeCategory()
    {
        return $this->belongsTo('App\Entities\CollegeCategory', 'category_id');
    }

    /**
     * 关联大学层次
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collegeDiplomas()
    {
        return $this->belongsTo('App\Entities\CollegeDiplomas', 'diplomas_id');
    }

    /**
     * 关联大学所在省份
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo('App\Entities\Province');
    }
}
