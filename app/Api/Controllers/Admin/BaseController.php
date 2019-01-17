<?php

namespace App\Api\Controllers\Admin;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\Serializers\PageSerializer;
use App\Api\Serializers\ResponseFormat;
use App\Api\Serializers\DataArraySerializer;

class BaseController extends Controller
{
    use Helpers;

    /**
     * @var \Tymon\JWTAuth\Facades\JWTAuth
     */
    public $jwt;

    /**
     * @var \App\Api\Serializers\ResponseFormat
     */
    public $responseFormat;

    /**
     * @var PageSerializer
     */
    public $pageSerializer;

    /**
     * @var \App\Api\Serializers\DataArraySerializer
     */
    public $dataArraySerializer;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->init(new JWTAuth(), new ResponseFormat(), new PageSerializer(), new DataArraySerializer());

            return $next($request);
        });
        //$this->middleware('auth:admin_api', ['except' => ['login']]);
    }

    /**
     * 初始化后台所需的各种类库
     *
     * @param $jwt
     * @param $responseFormat
     * @param $pageSerializer
     * @param $dataArraySerializer
     */
    public function init($jwt, $responseFormat, $pageSerializer, $dataArraySerializer)
    {
        $this->jwt = $jwt;
        $this->responseFormat = $responseFormat;
        $this->pageSerializer = $pageSerializer;
        $this->dataArraySerializer = $dataArraySerializer;
    }
}