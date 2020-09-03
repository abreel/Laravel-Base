<?php
/**
 * @see App\Base\Contracts\CheckAuth
 */

namespace App\Base\Contracts;

use App\Base\Base;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

interface AuthContract
{

    /**
     * Initialize checkAuth
     *
     * @param Request $request
     */
    public function __construct(Request $request, Router $router, Base $base);

    /**
     * Check method's policy
     *
     * @return boolean
     */
    public function checkMethodPolicy();

    /**
     * Get permission's name
     *
     * @return string
     */
    public function getPermissionName();

    /**
     * Get permission
     *
     * @return string
     */
    public function getPermission();

    /**
     * Check user's permission
     *
     * @return boolean
     */
    public function checkPermission();
}
