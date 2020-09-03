<?php

namespace App\Base\Contracts;

use App\Base\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViewMethod implements ControllerContract
{
    /**
     * Instance of Base class
     *
     * @var App\Base\Base
     */
    private $base;

    /**
     * Instance of FetchModel class
     *
     * @var App\Base\Contracts\FetchModel
     */
    private $fetchModel;

    /**
     * Model name
     *
     * @var string
     */
    private $name;

    /**
     * Current Model
     *
     * @var string
     */
    private $model;

    /**
     * Initialize class
     *
     * @param App\Base\Base $base
     * @param App\Base\Contracts\FetchModel $fetchModel
     */
    public function __construct(Base $base, FetchModel $fetchModel)
    {
        // set base
        $this->base = $base;

        // set fetch model
        $this->fetchModel = $fetchModel;
    }

    /**
     * Get model name
     *
     * @return string
     */
    public function getName()
    {
        if (
            $this->fetchModel->length() === 'single' ||
            $this->fetchModel->length() === 'none'
            ) {
            $this->name =  $this->base->getName();
            return  $this->name;
        }

        if ($this->fetchModel->length() === 'multiple') {
            $this->name = $this->base->getPluralName();
            return $this->name;
        }
    }

    /**
     * Get current model
     *
     * @return object
     */
    public function getModel()
    {
        $this->model =  $this->fetchModel->return();
        return $this->model;
    }

    /**
     * Get current views folder
     *
     * @param array $array
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function getView(array $array)
    {
        return $array['model']
            ? view(
                $this->base->getViewsFolder() . '.' . $this->base->getCurrentMethod(),
                [
                    'singularName' => $this->base->getName(),
                    'pluralName' => $this->base->getPluralName(),
                    $this->base->length() === 'single'
                        ? $this->base->getName()
                        : $this->base->getPluralName() => $array['model'],
                    'extra' => $array['extra']
                ]
            )
            : view(
                $this->base->getViewsFolder() . '.' . $this->base->getCurrentMethod(),
                [
                    'singularName' => $this->base->getName(),
                    'pluralName' => $this->base->getPluralName(),
                    'extra' => $array['extra']
                ]
            )->with(session("old"))->with(old());
    }

    /**
     * Process request
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function process(array $parameters)
    {
        $this->base->setMethodParameters($parameters);
        return $this->getView($this->fetchModel->process());
    }
}
