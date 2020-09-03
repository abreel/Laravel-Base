<?php

namespace App\Base\Traits;


use Illuminate\Support\Str;

/**
 * Helpers for the base controller
 */
trait Helpers
{
    /**
     * Fetch a model
     *
     * @return void
     */
    public function fetchModel()
    {
        //
    }

    /**
     * Fetch a related model
     *
     * @return void
     */
    public function fetchRelatedModel()
    {
        //
    }

    /**
     * Set middleware for application using controller policy
     *
     * @return middleware
     */
    public function setMiddleware()
    {
        // all methods should authenticate
        if ($this->policy['all']) {
            // dd("We in here");
            return $this->middleware('auth');
        }
        // exceptions (methods to not authenticate) array
        $exceptions = [];

        // check methods with exception (to not authenticate)
        foreach ($this->policy as $method => $value) {
            $method != 'all' && !$value
                ? array_push($exceptions, $method)
                : '';
        }

        // set authentication middleware
        return $exceptions
            ? $this->middleware('auth')->except($exceptions)
            : $this->middleware('auth');
    }

}
?>
