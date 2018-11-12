<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Utilities\ConfigHelper;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $apiVersion = 'v1';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        //如果允许模块的话，去检测routes/模块.app.php中的路由规则  并建议 模块(首字母大写)/v1/。。。文件目录
        if (!empty($allowModules = ConfigHelper::getAllowModule())) {
            foreach ($allowModules as $module) {
                $this->moduleRoutes($module);
            }
            //文档首页
            if (ConfigHelper::isDebug()) {
                $this->docsRoutes();
            }

        }
//        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    // 加载模块所对应的路由和文档
    protected function moduleRoutes($module)
    {
        //去加载对应模块的api路由器
        Route::prefix($module . '/' . $this->apiVersion)
//            ->middleware("api")
            ->namespace($this->namespace . '\\' . ucwords($module) . '\\' . $this->apiVersion)
            ->group(base_path('routes/api.' . $module . '.php'));

        // 如果是Debug模式，则加载本模块的文档;
        if (ConfigHelper::isDebug()) {
            Route::group([
                'prefix' => 'docs/json',
                'namespace' => $this->namespace . '\\' . ucwords($module) . '\\' . $this->apiVersion
            ], function () use ($module) {
                Route::get($module, 'SwaggerController@getjson');
            });
        }

    }

    //加载文档汇总页
    protected function docsRoutes()
    {
//                $exp = '^('.implode('|',$allowModules).')$';
        Route::group([
            'prefix' => 'docs',
            'namespace' => $this->namespace
        ], function () { //use ($exp)
            Route::get('/', 'DocsController@index');
            Route::get('{module}.html', 'DocsController@index'); //->where('module', $exp)
        });

    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
//    protected function mapApiRoutes()
//    {
//        Route::prefix('api')
//             ->middleware('api')
//             ->namespace($this->namespace)
//             ->group(base_path('routes/api.php'));
//    }
}
