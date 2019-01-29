<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class VipCard.
 *
 * @package namespace App\Entities;
 */
class VipCard extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'low_price',
        'high_price',
        'xgkxk',
        'gjkmxzy',
        'gjzyxkm',
        'ljdxzy',
        'zyzyt',
        'tswlzy',
        'zyxgcs',
        'sxtjzn',
        'sxtjfx',
        'xxfgcp',
        'sjglcy',
        'xltjcy',
        'qxglcy',
        'zzyxdw',
        'zzyxcx',
        'cshzy',
        'zzhdsj',
        'zzsjfx',
        'zzyxxb',
        'znxxx',
        'lqfxpg',
        'twcksqx',
        'tfksqx',
        'zydzbg',
        'zyfscx',
        'yfydb',
        'skxfscx',
        'gxcx',
        'gxfscx',
        'dxpm',
        'zycx',
        'description',
    ];

}
