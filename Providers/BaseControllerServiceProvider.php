<?php

namespace App\Base\Providers;

use App\Base\Base;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Base\Contracts\AuthContract;
use Illuminate\Support\ServiceProvider;
use App\Base\Contracts\ControllerContract;
use Exception;
use App\Base\Http\Requests\BaseRequest;
use App\Base\Http\Controllers\BaseController;
use App\Base\Contracts\ViewMethod;
use App\Base\Contracts\DeleteMethod;
use App\Base\Contracts\StorageMethod;
use App\Base\Contracts\FetchModel;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Validation\ValidationException;

class BaseControllerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving(BaseController::class, function ($baseController, $app) {
            $base = $app->make(Base::class);
            // resolve developer's setting
            if(property_exists($baseController, 'setting')){
                return $base->setting($baseController->setting);
            }
            return;
        });

        $this->app->singleton(ControllerContract::class, function ($app) {
            $base = $app->make(Base::class);
            // View method
            if (in_array($base->getCurrentMethod(), $base->getViewMethods())) {
                return new ViewMethod($app->make(Base::class), $app->make(FetchModel::class));
            }

            // Storage method
            if (in_array($base->getCurrentMethod(), $base->getStorageMethods())) {
                return new StorageMethod(
                    $app->make(Base::class),
                    $app->make(FetchModel::class),
                    $app->make(ViewMethod::class)
                );
            }

            // Delete method
            if (in_array($base->getCurrentMethod(), $base->getDeleteMethods())) {
                return new DeleteMethod($app->make(Base::class), $app->make(FetchModel::class));
            }

            throw new Exception("Current method cannot be processed, please make sure that the current method (e.g. create, edit) is a default laravel model, or has been registered as an accessible method in the child controller");
        });

        $this->app->singleton(Base::class, function ($app) {
            return new Base($app->make(Router::class), $app->make(Request::class));
        });

        $this->app->singleton(BaseRequest::class, function ($app) {
            return new BaseRequest($app->make(Request::class), $app->make(Base::class));
        });

        $this->app->singleton(FetchModel::class, function ($app) {
            return new FetchModel($app->make(Base::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ControllerContract::class,
            BaseController::class,
            Base::class,
            BaseRequest::class,
            FetchModel::class,
        ];
    }
}
