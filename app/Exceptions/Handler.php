<?php

namespace App\Exceptions;

use App\Utilities\ConfigHelper;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Utilities\ResponseHelper;
use App\Utilities\ReturnCodeHelper;

class Handler extends ExceptionHandler
{
    use ReturnCodeHelper, ResponseHelper;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        // 针对于开放的模块，使用json的404方案
        if (!empty($allowModules = ConfigHelper::getAllowModule())) {
            // 把开放的模块整理成匹配规则
            // $patterns = ['api/*','admin/*','cli/*'];
            $patterns = [];
            foreach ($allowModules as $k => $module) {
                $patterns[$k] = $module . '/*';
            }
            // 'api/*'
            //把开放的规则 进行放行判断
            if ($request->is(...$patterns)) {
                $error = $this->convertExceptionToResponse($exception);
                list ($returnName, $returnInfo) = $this->transStatusCodeToReturnCode($error->getStatusCode());
                $returnData = [];
                if (config('app.debug')) {

                    if (!empty($exception->getMessage())) $returnInfo = $exception->getMessage();
                    //特别处理一个验证的信息

                    // 兼容验证插件
                    if ($returnInfo == 'The given data was invalid.') {
                        $returnName = 'PARAM_LACK';
                        $message = $exception->errors();
                        $returnInfo = reset($message)[0];
                    }

                    // 兼容用户登陆插件
                    if ($returnInfo == 'Unauthenticated') {
                        $returnName = 'TOKEN_LOST';
                        $returnInfo = '';
                    }

                    if ($error->getStatusCode() >= 500) {
                        $returnData = array(
                            'status' => $error->getStatusCode(),
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                            'error' => $exception->getTrace(),
                        );
                    };
                    $this->responseJson($returnName, $returnInfo, $returnData);
                    //$exception->getCode()
                }
                $this->responseJson($returnName, $returnInfo, $returnData);
            }
        }
        return parent::render($request, $exception);
    }
}
