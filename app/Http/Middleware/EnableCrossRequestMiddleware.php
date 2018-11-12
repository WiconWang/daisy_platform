<?php

namespace App\Http\Middleware;

use Closure;

class EnableCrossRequestMiddleware
{
    /**EnableCrossRequestMiddleware
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
//    public function handle($request, Closure $next)
//    {
//        return $next($request);
//    }
    public function handle($request, Closure $next)
    {
        $response = $next($request);
//        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
//        $allow_origin = [
//            'localhost:8080',
//        ];
        $origin = '*';
//        if (in_array($origin, $allow_origin)) {
        // 跨域域名
        $response->header('Access-Control-Allow-Origin', $origin);
        // 跨域字段
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type,xfilename,xfilecategory,xfilesize, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN, token,account,username');
        $response->header('Access-Control-Expose-Headers', 'Authorization, authenticated');
        //跨域类别
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS, DELETE');

//            $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Allow-Credentials', 'false');
//        }
        return $response;
    }
}
