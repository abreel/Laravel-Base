<?php

namespace App\Base\Contracts;

use App\Base\Base;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class CheckAuth implements AuthContract
{
    public $request;
    public $router;
    private $base;

    /**
     * Initialize checkAuth
     *
     * @param Request $request
     */
    public function __construct(Request $request, Router $router, Base $base)
    {
        $this->request = $request;
        $this->router = $router;
        $this->base = $base;
    }

    /**
     * Check method's policy
     *
     * @return boolean
     */
    public function checkMethodPolicy()
    {
        if($this->base->getPolicy()['all'] !== null){
            return $this->base->getPolicy()['all'];
        }
        return $this->base->getPolicy()[$this->base->getCurrentMethod()];
    }

    /**
     * Get permission's name
     *
     * @return string
     */
    public function getPermissionName()
    {
        return config(
            'dec-base.policy.'.$this->base->getCurrentMethod(),
            $this->permission
                        [config('dec-base.permissionManager', 'default')]
                        [$this->base->getCurrentMethod()]
        );
    }

    /**
     * Get permission
     *
     * @return string
     */
    public function getPermission()
    {
        $policy = $this->base->getPolicy()[Config('dec-base.policy')][$this->base->getCurrentMethod()];

        // get permission
        return $this->base->slug("_", null, $policy);
    }

    /**
     * Check user's permission
     *
     * @return boolean
     */
    public function checkPermission()
    {
        if(!$this->checkMethodPolicy()){
            return;
        }

        // if user is not authenticated
        if(!auth()->user()){
            throw new AuthenticationException(
                'Unauthenticated.',
                ['web']
            );
        }

        if(!auth()->user()->hasPermission($this->getPermission())){
            return abort(403);
        }

        return;
    }
}
