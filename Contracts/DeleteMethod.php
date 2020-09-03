<?php

namespace App\Base\Contracts;

use App\Base\Base;

class DeleteMethod implements ControllerContract
{

    /**
     * Instance of base class
     *
     * @var object
     */
    protected $base;

    /**
     * Instance of fetchModel class
     *
     * @var object
     */
    protected $fetchModel;

    /**
     * Initialize contract
     *
     * @param App\Base\Base $base
     * @param App\Base\Contracts\FetchModel $fetchModel
     */
    public function __construct(Base $base, FetchModel $fetchModel)
    {
        dd("In the delete method class");

        $this->base = $base;
        $this->fetchModel = $fetchModel;
    }

    /**
     * Get model name
     *
     * @return string
     */
    public function getName()
    {
    }

    /**
     * Get current model
     *
     * @return object
     */
    public function getModel()
    {
    }

    /**
     * Get current views folder
     *
     * @param object $model
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function getView($model)
    {
    }

    /**
     * Process request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function process()
    {


        $request = $parameters[0];
        $this->setCurrentRequest($parameters[0]);

        // call request processor
        $data = $this->formProcessor($this->getCurrentRequest());

        // loop through data
        foreach ($data as $field => $value) {

            // check for images
            if (stripos($field, 'image')) {

                // not empty or null
                if ($field) {
                    // store image
                    $imagePath = request($field)
                        ->store(
                            config('dec-base.imagePath', 'img') . "/" . $this->getPluralName(),
                            config('dec-base.fileStorageDriver', 'public')
                        );

                    // merge imagepath with the request array
                    $data = array_merge($data, [
                        $field => $imagePath,
                    ]);
                }

                // empty or null
                else {
                }
            }
        }


        // store data
        if ($method === "store") {
            $this->getModel()::create($data);
        }

        // update data
        if ($method === "update") {
            $id = $parameters[1];

            $model = $this->getModel()::findOrFail($id);

            // loop through
            foreach ($data as $field => $value) {

                // update database
                $model->$field = $value;
            }

            $model->save();
        }
    }
}
