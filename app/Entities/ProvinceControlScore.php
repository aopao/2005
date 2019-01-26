<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProvinceControlScore.
 *
 * @package namespace App\Entities;
 */
class ProvinceControlScore extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['province_id', 'year', 'subject', 'batch', 'score'];

    /**
     * 关联省控线省份表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo('App\Entities\Province');
    }
}
