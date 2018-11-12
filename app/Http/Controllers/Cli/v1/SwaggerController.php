<?php

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="终端任务——接口",
 *     ),

 *     @OA\Server(
 *         description="OpenApi host",
 *         url="/cli/v1"
 *     ),
 * )
 */
namespace App\Http\Controllers\Cli\v1;

use \Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utilities\ConfigHelper;

class SwaggerController extends Controller
{

    public function __construct()
    {
        if(!ConfigHelper::isDebug()){
            throw new Exception('Permission denied');
        }

    }

    public function getjson()
    {
        $swagger = \OpenApi\scan(app_path('Http/Controllers/Cli/v1'));
        return response()->json($swagger,200);

    }
}
