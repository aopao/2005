<?php

namespace App\Api\Controllers\Admin;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\Serializers\DataSerializer;
use App\Api\Serializers\PageSerializer;

class BaseController extends Controller
{
    use Helpers;

    /**
     * @var \Tymon\JWTAuth\Facades\JWTAuth
     */
    public $jwt;

    /**
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * @var \App\Api\Serializers\DataSerializer
     */
    public $dataSerializer;

    /**
     * @var PageSerializer
     */
    public $pageSerializer;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->init(new JWTAuth(), new Request(), new DataSerializer(), new PageSerializer());

            return $next($request);
        });
        //$this->middleware('auth:admin_api', ['except' => ['login']]);
    }

    /**
     * 初始化后台所需的各种类库
     *
     * @param $jwt
     * @param $request
     * @param $dataSerializer
     * @param $pageSerializer
     */
    public function init($jwt, $request, $dataSerializer, $pageSerializer)
    {
        $this->jwt = $jwt;
        $this->request = $request;
        $this->dataSerializer = $dataSerializer;
        $this->pageSerializer = $pageSerializer;
    }
}