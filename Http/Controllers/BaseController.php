<?php

/**
 * @see App\Base\Contracts\AuthContract for user authentication
 * @see App\Base\Contracts\ControllerContract for method processing
 * @see App\Base\Base for general management
 */

namespace App\Base\Http\Controllers;

use Exception;
use App\Base\Base;
use App\Base\Contracts\AuthContract;
use App\Http\Controllers\Controller;
use App\Base\Contracts\ControllerContract;

class BaseController extends Controller
{
    //   protected $controllerContract;
    //   protected $base;

    /**
     * Initialize properties
     *
     * @param base $method
     * @param [type] $parameters
     * @return void
     */
    public function __construct(Base $base, ControllerContract $controllerContract, AuthContract $authContract)
    {
        $this->base = $base;
        $this->controllerContract = $controllerContract;
        // $authContract->checkPermission();

        // Authenticate end-user
        // $app->make(AuthContract::class);
        // dd("Basecontroller class");
    }

    /**
     * Dynamically handle calls
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // check for required parameters
        if ((count($parameters) !== 1 && $method === "update")) {
            $parameterLength = $method === "update" ? 2 : 1;
            throw new Exception("$parameterLength parameter(s) expected for $method method, ".count($parameters)." given");
        }

        // check for undefined method
        if(!in_array($method, $this->base->getAllMethods())){
            throw new Exception("Undefined method! Please check your route and make sure the model has been created", 1);
        }

        // processor
        return $this->controllerContract->process($parameters);
    }
}
