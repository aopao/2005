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
class CollegeDetail extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * 设置数据库表
     *
     * @var string
     */
    protected $table = "college_details";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
}
