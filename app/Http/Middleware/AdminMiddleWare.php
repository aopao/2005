<?php

namespace App\Http\Middleware;

use Route;
use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class AdminMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (Auth::check()) {
                //获取用户模型
                $user = Auth::guard('admin')->user();
                //获取当前地址路由
                $uri = $request->route()->getName();
                //判断是否有此权限
                $res = $user->hasPermissionTo($uri);
                //根据结果跳转不同地址
                if ($res) {
                    return $next($request);
                } else {
                    abort(404);
                }
            }
        } catch (PermissionDoesNotExist $exception) {
            return response()->json(['status_code' => '403']);
        }
    }
}
