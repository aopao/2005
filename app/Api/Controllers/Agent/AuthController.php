<?php

namespace App\Api\Controllers\Agent;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * AuthController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    /**
     * Login Method
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $data = $this->request->all();
        if (! $token = Auth::guard('agent')->attempt($data)) {
            return response()->json(['error' => '用户名或者密码错误!', 'status_code' => 401], 401);
        } else {
            $admin = Auth::guard('agent')->user()->toArray();

            return $this->respondWithToken($admin, $token);
        }
    }

    /**
     * Logout Method
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'code' => '200',
        ]);
    }

    /**
     * 设置守卫
     *
     * @return mixed
     */
    public function guard()
    {
        return JWTAuth::guard();
    }

    /**
     * Get the token array structure.
     *
     * @param         $admin
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($admin, $token)
    {
        if (isset($admin['id'])) {
            unset($admin['id']);
        }
        $data = $this->responseFormat->success($admin);
        $data['access_token'] = 'Bearer '.$token;

        return response()->json($data);
    }
}