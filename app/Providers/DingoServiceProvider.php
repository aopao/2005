<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DingoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /**
         * 自定义返回数据类型
         */
        $this->app['Dingo\Api\Transformer\Factory']->setAdapter(function ($app) {
            $fractal = new \League\Fractal\Manager;
            $fractal->setSerializer(new \App\Api\Serializers\DataArraySerializer);

            return new \Dingo\Api\Transformer\Adapter\Fractal($fractal);
        });
    }

    public function register()
    {

    }
}