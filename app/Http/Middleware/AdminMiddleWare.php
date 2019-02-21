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
            if (Auth::guard('admin')->check()) {
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
                    return response()->json(['status' => 403, 'message' => '您的权限不足,无法进行操作,请联系管理员!']);
                }
            } else {
                return response()->json(['status' => '201', 'message' => '未登录!']);
            }
        } catch (PermissionDoesNotExist $exception) {
            return response()->json(['status' => 403, 'message' => '您的权限不足,无法进行操作,请联系管理员!']);
        }
    }
}
