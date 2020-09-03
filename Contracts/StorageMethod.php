<?php

namespace App\Base\Contracts;

use Exception;
use App\Base\Base;
use App\Base\Contracts\FetchModel;
use App\Base\Contracts\ViewMethod;
use Illuminate\Support\Facades\Validator;

class StorageMethod implements ControllerContract
{

    /**
     * Instance of @link Request class
     *
     * @var object
     */
    protected $request;

    /**
     * Instance of @link ViewMethod class
     *
     * @var object
     */
    protected $viewMethod;

    /**
     * Instance of @link App\Base\Base class
     *
     * @var object
     */
    protected $base;

    /**
     * Instance of @link App\Base\Contracts\FetchModel class
     *
     * @var object
     */
    protected $fetchModel;

    /**
     * Validated data
     *
     * @var array
     */
    protected $data;

    /**
     * Initialize contract
     *
     * @param App\Base\Base $base
     * @param App\Base\Contracts\FetchModel $fetchModel
     * @param App\Base\Contracts\ViewMethod $viewMethod
     */
    public function __construct(Base $base, FetchModel $fetchModel, ViewMethod $viewMethod)
    {
        $this->base = $base;
        $this->fetchModel = $fetchModel;
        $this->viewMethod = $viewMethod;
    }

    /**
     * Validate form data
     *
     * @return array
     */
    public function validate()
    {
        return $this->data = Validator::make(
            $this->base->getRequest()->all(),
            $this->base->processRules()
        )->validate();
    }

    /**
     * Process based on current method
     *
     * @return boolean
     */
    public function checkCurrent()
    {
        // update method
        if ($this->base->getCurrentMethod() === "update") {
            return $this->base->updateModel($this->data);
        }

        // store method
        if ($this->base->getCurrentMethod() === "store") {
            return $this->base->storeModel($this->data);
        }

        throw new Exception("Update or store methods expected, unknown storage method found.");
    }

    /**
     * Return redirect
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function returnRedirect()
    {
        $route = $this->base->getRedirect($this->base->getCurrentMethod());

        if (!$route) {
            throw new Exception("Route expected, empty string given.");
        }

        $message = $this->base->statusMessage();

        if($route === "previous"){
            return back()->with($message);
        }else {
            return $this->base->baseRedirect($route, $message);
        }
    }

    /**
     * Process request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function process(array $parameters)
    {
        $this->base->setMethodParameters($parameters);

        // validate
        $this->validate();

        // process
        if($this->checkCurrent()){
            // operation completed
            return $this->returnRedirect();
        }

        // error
        $message = "An unknown error occured while processing your request. Please try again later and if problem persists, contact the administrator. We apologise for any inconvenience caused.";
        return back()->with($this->base->statusMessage(null, $message));
    }
}
