<?php
namespace App\Base\Traits;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

/**
 * Holds base files
 */
trait Base
{
    use PolicyActions;

    /**
     * Eloquent model
     *
     * @var mixed
     */
    private $model;

    /**
     * model name
     *
     * @var string
     */
    private $name;

    /**
     * model name (plural)
     *
     * @var string
     */
    private $pluralName;

    /**
     * views folder name or directory [excluding resources/views]
     *
     * @var string
     */
    private $viewsFolder;

    /**
     * Current controller method
     *
     * @var string
     */
    private $currentMethod;

    /**
     * Form request validator
     *
     * @var string
     */
    private $validator;

    /**
     * Current request
     *
     * @var Illuminate\Http\Request
     */
    private $currentRequest;

    /**
     * All methods
     *
     * @var array
     */
    private $allMethods = ['edit', 'show', 'index', 'create', 'update', 'store', 'delete', 'forceDelete'];

    /**
     * Methods with views
     *
     * @var array
     */
    private $viewMethods = ['edit', 'show', 'index', 'create'];

    /**
     * Database manipulation methods
     *
     * @var array
     */
    private $storageMethods = ['update', 'store'];

    /**
     * Deleting methods
     *
     * @var array
     */
    private $deleteMethods = ['delete', 'forceDelete'];

    /**
     * Set defualts
     *
     * @param  string  $name  defualts
     *
     * @return  self
     */
    // public function setDefault(Router $router, Request $request)
    public function setDefault(Router $router)
    {

        $name = substr(
            $router->currentRouteName(),
            0,
            strpos($router->currentRouteName(), '.')
        );

        $this->setName($name);
        $this->setPluralName($name);
        $this->setViewsFolder($this->getPluralName());
        // $this->setCurrentRequest($request);

        return $this;
    }

    /**
     * Redirect to a route
     * with a message
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function baseRedirect()
    {
        return redirect()
            ->route("$this->name.index")
            ->with([
                "status" => true,
                "status_message" => Str::title($this->name) . " deleted.",
            ]);
    }

    /**
     * Current eloquent model
     *
     * @param  mixed  $model  Eloquent model
     *
     * @return  self
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set model name
     *
     * @param  string  $name  model name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = Str::lower($name);

        return $this;
    }

    /**
     * Set model name (plural)
     *
     * @param  string  $name  model name (plural)
     *
     * @return  self
     */
    public function setPluralName(string $name)
    {
        $this->pluralName = Str::lower(Str::plural($name));

        return $this;
    }

    /**
     * Set views folder name or directory [excluding resources/views]
     *
     * @param  string  $viewsFolder  views folder name or directory [excluding resources/views]
     *
     * @return  self
     */
    public function setViewsFolder(string $viewsFolder)
    {
        $this->viewsFolder = $viewsFolder;

        return $this;
    }

    /**
     * Get views folder name or directory [excluding resources/views]
     *
     * @return  string
     */
    public function getViewsFolder()
    {
        return $this->viewsFolder;
    }

    /**
     * Get model name (plural)
     *
     * @return  string
     */
    public function getPluralName()
    {
        return $this->pluralName;
    }

    /**
     * Get model name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get eloquent model
     *
     * @return  mixed
     */
    public function getModel()
    {
        return $this->model;
    }



    /**
     * Boolean
     *
     * @param bool $index (true/false)
     * @param bool $edit (true/false)
     * @param bool $update (true/false)
     * @param bool $store (true/false)
     * @param bool $create (true/false)
     * @param bool $delete (true/false)
     * @param bool $forceDelete (true/false)
     *
     * @return self
     */
    public function setPolicy(bool $index, bool $show, bool $edit, bool $update, bool $store, bool $create, bool $destroy, bool $forceDelete)
    {
        $this->policy['index'] = $index;
        $this->policy['show'] = $show;
        $this->policy['edit'] = $edit;
        $this->policy['update'] = $update;
        $this->policy['store'] = $store;
        $this->policy['create'] = $create;
        $this->policy['destroy'] = $destroy;
        $this->policy['forceDelete'] = $forceDelete;

        return $this;
    }

    /**
     * Set all policy to true/false
     *
     * @return self
     */
    public function setAllPolicy(bool $policy)
    {
        $this->policy['all'] = $policy;

        return $this;
    }

    /**
     * Set indexpolicy
     *
     * @param  bool  $policyIndex  Indexpolicy
     *
     * @return  self
     */
    public function setPolicyIndex(bool $policyIndex)
    {
        $this->policy['index'] = $policyIndex;

        return $this;
    }

    /**
     * Set showpolicy
     *
     * @param  bool  $policyShow  Showpolicy
     *
     * @return  self
     */
    public function setPolicyShow(bool $policyShow)
    {
        $this->policy['show'] = $policyShow;

        return $this;
    }

    /**
     * Set editpolicy
     *
     * @param  bool  $policyEdit  Editpolicy
     *
     * @return  self
     */
    public function setPolicyEdit(bool $policyEdit)
    {
        $this->policy['edit'] = $policyEdit;

        return $this;
    }

    /**
     * Set updatepolicy
     *
     * @param  bool  $policyUpdate  Updatepolicy
     *
     * @return  self
     */
    public function setPolicyUpdate(bool $policyUpdate)
    {
        $this->policy['update'] = $policyUpdate;

        return $this;
    }

    /**
     * Set createpolicy
     *
     * @param  bool  $policyCreate  Createpolicy
     *
     * @return  self
     */
    public function setPolicyCreate(bool $policyCreate)
    {
        $this->policy['create'] = $policyCreate;

        return $this;
    }

    /**
     * Set storepolicy
     *
     * @param  bool  $policyStore  Storepolicy
     *
     * @return  self
     */
    public function setPolicyStore(bool $policyStore)
    {
        $this->policy['store'] = $policyStore;

        return $this;
    }

    /**
     * Set destroypolicy
     *
     * @param  bool  $policyDestroy  Destroypolicy
     *
     * @return  self
     */
    public function setPolicyDestroy(bool $policyDestroy)
    {
        $this->policy['destroy'] = $policyDestroy;

        return $this;
    }

    /**
     * Set forceDeletepolicy
     *
     * @param  bool  $policyForceDelete  ForceDeletepolicy
     *
     * @return  self
     */
    public function setPolicyForceDelete(bool $policyForceDelete)
    {
        $this->policy['forceDelete'] = $policyForceDelete;

        return $this;
    }

    /**
     * Get current controller method
     *
     * @return  string
     */
    public function getCurrentMethod()
    {
        return $this->currentMethod;
    }

    /**
     * Set current controller method
     *
     * @param  string  $currentMethod  Current controller method
     *
     * @return  self
     */
    public function setCurrentMethod(string $currentMethod)
    {
        $this->currentMethod = $currentMethod;

        return $this;
    }

    /**
     * Get methods with views
     *
     * @return  array
     */
    public function getViewMethods()
    {
        return $this->viewMethods;
    }

    /**
     * Get deleting methods
     *
     * @return  array
     */
    public function getDeleteMethods()
    {
        return $this->deleteMethods;
    }

    /**
     * Get database manipulation methods
     *
     * @return  array
     */
    public function getStorageMethods()
    {
        return $this->storageMethods;
    }

    /**
     * Get current request
     *
     * @return  object
     */
    public function getCurrentRequest()
    {
        return $this->currentRequest;
    }

    /**
     * Set current request
     *
     * @param  Illuminate\Http\Request  $currentRequest  Current request
     *
     * @return  self
     */
    public function setCurrentRequest(Request $currentRequest)
    {
        $this->currentRequest = $currentRequest;

        return $this;
    }

    /**
     * Get all methods
     *
     * @return  array
     */
    public function getAllMethods()
    {
        return $this->allMethods;
    }
}


?>
