<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Major.
 *
 * @package namespace App\Entities;
 */
class Major extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'parent_id',
        'top_parent_id',
        'diplomas',
        'level',
        'ranking',
        'ranking_type',
        'created_at',
        'updated_at',
    ];

    /**
     * 关联专业详细表
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function majorDetail()
    {
        return $this->hasOne('App\Entities\MajorDetail')->select('clicks');
    }
}
