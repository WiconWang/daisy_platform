<?php

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Web版——接口",
 *     ),

 *     @OA\Server(
 *         description="OpenApi host",
 *         url="http://api.henan.hangyutech.com/web/v1"
 *     ),
 * )
 */

namespace App\Http\Controllers\Web\v1;

use App\Http\Controllers\Controller;

class SwaggerController extends Controller
{
    public function getjson()
    {
        $swagger = \OpenApi\scan(app_path('Http/Controllers/Web/v1'));
        return response()->json($swagger,200);

    }
}
