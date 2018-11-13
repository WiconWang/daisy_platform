<?php

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="超级管理后台——接口",
 *     ),

 *     @OA\Server(
 *         description="OpenApi host",
 *         url="http://www.visithenan.cn:89/admin/v1"
 *     ),
 * )
 */

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;

class SwaggerController extends Controller
{
    public function getjson()
    {
        $swagger = \OpenApi\scan(app_path('Http/Controllers/Admin/v1'));
        return response()->json($swagger,200);

    }
}
