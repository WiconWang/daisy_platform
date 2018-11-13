<?php

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="用户后台——接口",
 *     ),

 *     @OA\Server(
 *         description="OpenApi host",
 *         url="http://api.daisy.hangyutech.com/user/v1"
 *     ),
 * )
 */

namespace App\Http\Controllers\User\v1;

use App\Http\Controllers\Controller;

class SwaggerController extends Controller
{
    public function getjson()
    {
        $swagger = \OpenApi\scan(app_path('Http/Controllers/User/v1'));
        return response()->json($swagger,200);

    }
}
