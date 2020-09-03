<?php

namespace App\Base\Traits;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;


/**
 * Set policy actions
 */
trait GettersAndSetters
{
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
     * Form request validation rules
     *
     * @var array
     */
    private $validationRules = [
        'store' => [
            'rules' => [],
            'required' => [],
        ],
        'update' => [
            'rules' => [],
            'required' => [],
        ],
    ];

    /**
     * Current method's parameters
     *
     * @var array
     */
    private $methodParameters = [];

    /**
     * Related models
     *
     * @var array
     */
    private $related = [];

    /**
     * Additional models displayed to end-users
     *
     * @var array
     */
    private $extra = [];

    /**
     * Allowed methods
     *
     * @var array
     */
    private $allowedMethods = ['*'];

    /**
     * Not allowed methods
     *
     * @var array
     */
    private $notAllowedMethods = [];

    /**
     * Requires no models
     *
     * @var array
     */
    private $noModel = ['create'];

    /**
     * Requires single models
     *
     * @var array
     */
    private $singleModel = ['edit', 'show', 'update', 'delete', 'forceDelete'];

    /**
     * Requires multiple models
     *
     * @var array
     */
    private $multipleModel = ['index'];

    /**
     * All methods
     *
     * @var array
     */
    private $allMethods = ['edit', 'show', 'index', 'create', 'update', 'store', 'delete', 'forceDelete'];

    /**
     * Current method that requires model
     *
     * @var boolean|null
     */
    private $currentRequiresModel = null;

    /**
     * Methods that requires model
     *
     * @var array
     */
    private $requiresModel = ['edit', 'show', 'index'];

    /**
     * Methods that requires validation
     *
     * @var array
     */
    private $requiresValidation = ['edit', 'create', 'update', 'store'];

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
     * User created methods (outside the default laravel methods)
     *
     * @var array
     */
    private $userMethods = [];

    /**
     * Instance of @link Illuminate\Http\Request
     *
     * @var Illuminate\Http\Request
     */
    public $request;

    /**
     * Router
     *
     * @var Illuminate\Routing\Router
     */
    public $router;

    /**
     * Fields to be stored in storage
     *
     * @var array
     */
    private $storeFields = [];

    /**
     * Paths to store different files
     *
     * @var array
     */
    private $storagePath = [];

    /**
     * Return redirect after completion
     *
     * @var array
     */
    private $redirect = [
        'all' => 'null',
        'store' => 'previous',
        'update' => 'previous',
    ];

    /**
     * Available settings for user
     *
     * @var array
     */
    private $settings = [
        'extra',
        'related',
        'allPolicy',
        'indexPolicy',
        'showPolicy',
        'editPolicy',
        'updatePolicy',
        'createPolicy',
        'storePolicy',
        'destroyPolicy',
        'forceDeletePolicy',
        'deleteMethods',
        'viewMethods',
        'storageMethods',
        'requiresModel',
        'currentRequiresModel',
        'allMethods',
        'noModel',
        'singleModel',
        'multipleModel',
        'viewFolder',
        'validator',
        'name',
        'model',
        'pluralName',
        'validationRules',
        'storeFields',
        'storagePath',
        'redirect',
    ];

    /**
     * Policy verbs for controller actions
     *
     * @var array
     */
    private $permission = [
        'voyager' => [
            'index' => 'browse',
            'show' => 'read',
            'edit' => 'edit',
            'update' => 'update',
            'create' => 'add',
            'store' => 'add',
            'delete' => 'delete',
            'destroy' => 'delete',
            'forceDelete' => 'delete',
        ],
        'default' => [
            'index' => 'viewAny',
            'show' => 'view',
            'edit' => 'update',
            'update' => 'update',
            'create' => 'store',
            'store' => 'store',
            'delete' => 'delete',
            'destroy' => 'delete',
            'forceDelete' => 'forceDelete',
        ],
    ];

    /**
     * Authorization default for controller methods
     * Controller policy
     *
     * @var array
     */
    private $policy = [
        'all' => null, // auto authorize all methods [null, true, false]
        'index' => false,
        'show' => false,
        'create' => false,
        'edit' => false,
        'store' => true,
        'update' => true,
        'destroy' => true,
        'forceDelete' => true,
    ];


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $rules = [
        /**
                 * User
                 */
        // user/profile
        'name' => ['string', 'max:255'],
        'firstname' => ['string', 'max:255'],
        'lastname' => ['string', 'max:255'],
        'surname' => ['string', 'max:255'],
        'middlename' => ['string', 'max:255'],
        'othername' => ['string', 'max:255'],
        // required

        // email
        'email' => ['email', 'max:255'],
        'email1' => ['email', 'max:255'],
        'email2' => ['email', 'max:255'],
        'email3' => ['email', 'max:255'],
        // required

        // mobile
        'mobile' => ['string', 'max:255'],
        'mobile1' => ['string', 'max:255'],
        'mobile2' => ['string', 'max:255'],
        'mobile3' => ['string', 'max:255'],
        // required

        // cell
        'cell' => ['string', 'max:255'],
        'cell1' => ['string', 'max:255'],
        'cell2' => ['string', 'max:255'],
        'cell3' => ['string', 'max:255'],
        // required

        // landline
        'landline' => ['string', 'max:255'],
        'landline1' => ['string', 'max:255'],
        'landline2' => ['string', 'max:255'],
        'landline3' => ['string', 'max:255'],
        // required

        // address
        'address' => ['string', 'max:255'],
        'address1' => ['string', 'max:255'],
        // required

        // street
        'street' => ['string', 'max:255'],
        'street1' => ['string', 'max:255'],
        // required

        // city
        'city' => ['string', 'max:255'],
        'city1' => ['string', 'max:255'],
        // required

        // state
        'state' => ['string', 'max:255'],
        'state1' => ['string', 'max:255'],
        // required

        // county
        'county' => ['string', 'max:255'],
        'county1' => ['string', 'max:255'],
        // required

        // lga - Local Goverment Area
        'lga' => ['string', 'max:255'],
        'lga1' => ['string', 'max:255'],
        // required

        // region
        'region' => ['string', 'max:255'],
        'region1' => ['string', 'max:255'],
        // required

        // country
        'country' => ['string', 'max:255'],
        'country1' => ['string', 'max:255'],
        // required

        // zip code
        'zip_code' => ['string', 'max:50'],
        'zip_code1' => ['string', 'max:50'],
        // required

        // postal code
        'postal_code' => ['string', 'max:50'],
        'postal_code1' => ['string', 'max:50'],
        // required



        /**
                 * Image
                 */
        // image
        'image' => ['image'],
        'image1' => ['image'],
        'image2' => ['image'],
        'image3' => ['image'],
        // required

        // cover image
        'cover_image' => ['image'],
        'cover_image1' => ['image'],
        'cover_image2' => ['image'],
        'cover_image3' => ['image'],
        // required

        // profile image
        'profile_image' => ['image'],
        'profile_image1' => ['image'],
        'profile_image2' => ['image'],
        'profile_image3' => ['image'],
        // required

        /**
                 * Product / material
                 */
        // product image
        'product_image' => ['image'],
        'product_image1' => ['image'],
        'product_image2' => ['image'],
        'product_image3' => ['image'],
        // required

        // material image
        'material_image' => ['image'],
        'material_image1' => ['image'],
        'material_image2' => ['image'],
        'material_image3' => ['image'],
        // required

        // price, discount and discounted price
        'price' => ['integer'],
        'price1' => ['integer'],
        'discount' => ['integer'],
        'discount1' => ['integer'],
        'discounted_price' => ['integer'],
        'discounted_price1' => ['integer'],
        // required


        /**
                 * Description
                 */
                'description' => ['string'],
                'short_description' => ['string'],
        'long_description' => ['string'],
        'full_description' => ['string'],
        // required


        /**
         * file
         *
         *
         */
        // file
        'file' => ['file'],
        'file1' => ['file'],
        'file2' => ['file'],
        'file3' => ['file'],
        // required

        /**
                 * Category
                 */
        // category_name
        'category_name' => ['string'],
        'category_name1' => ['string'],
        'category_name2' => ['string'],
        'category_name3' => ['string'],
        // required

        // category_id
        'category_id' => ['integer'],
        'category_id1' => ['integer'],
        'category_id2' => ['integer'],
        'category_id3' => ['integer'],
        // required




        /**
                 * messaging
                 */
        // message
        // message_name
        'message_name' => ['string'],
        'message_name1' => ['string'],
        'message_name2' => ['string'],
        'message_name3' => ['string'],
        // required

        // message_id
        'message_id' => ['integer'],
        'message_id1' => ['integer'],
        'message_id2' => ['integer'],
        'message_id3' => ['integer'],
        // required


        // sender
        // sender name
        'sender_name' => ['string'],
        'sender_name1' => ['string'],
        'sender_name2' => ['string'],
        'sender_name3' => ['string'],
        // required

        // sender_id
        'sender_id' => ['integer'],
        'sender_id1' => ['integer'],
        'sender_id2' => ['integer'],
        'sender_id3' => ['integer'],
        // required


        // receiver
        // receiver_name
        'receiver_name' => ['string'],
        'receiver_name1' => ['string'],
        'receiver_name2' => ['string'],
        'receiver_name3' => ['string'],
        // required

        // receiver_id
        'receiver_id' => ['integer'],
        'receiver_id1' => ['integer'],
        'receiver_id2' => ['integer'],
        'receiver_id3' => ['integer'],
        // required


        // thread
        // thread_name
        'thread_name' => ['string'],
        'thread_name1' => ['string'],
        'thread_name2' => ['string'],
        'thread_name3' => ['string'],
        // required

        // thread_id
        'thread_id' => ['integer'],
        'thread_id1' => ['integer'],
        'thread_id2' => ['integer'],
        'thread_id3' => ['integer'],
        // required


        // subject
        'subject' => ['string'],
        'subject1' => ['string'],
        // body
        'body' => ['string'],
        'body1' => ['string'],
    ];

    /**
     * Fetch rules for current request
     *
     * @return array|void
     */
    public function fetchRequestRules()
    {
        if (($this->request->all())) {
            return array_intersect_key($this->rules, $this->request->all());
        }

        return;
    }

    /**
     * Fetch user's rules for current request
     *
     * @return array|boolean
     */
    public function fetchUserRules()
    {
        // fetch user's validation rules
        $rules = $this->getValidationRules();

        // current method
        $currentMethod = $this->getCurrentMethod();

        // store method
        if ($currentMethod === "store") {
            return $rules['store'];
        }

        // update method
        else if ($currentMethod === "update") {
            return $rules['update'];
        } else {
            return false;
        }
    }

    /**
     * Get controller policy
     *
     * @return  array
     */
    public function getPolicy()
    {
        return $this->policy;
    }

    /**
     * Get policy verbs for controller actions
     *
     * @return  array
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Current eloquent model
     *
     * @param  mixed  $model  Eloquent model
     *
     * @return  self
     */
    private function setModel($model)
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
    private function setName(string $name)
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
    private function setPluralName(string $name)
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
    private function setViewsFolder(string $viewsFolder)
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
    private function setPolicy(bool $index, bool $show, bool $edit, bool $update, bool $store, bool $create, bool $destroy, bool $forceDelete)
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
    private function setAllPolicy(bool $policy)
    {
        $this->policy['all'] = $policy;

        return $this;
    }

    /**
     * Set indexpolicy
     *
     * @param  bool  $IndexPolicy  Indexpolicy
     *
     * @return  self
     */
    private function setIndexPolicy(bool $IndexPolicy)
    {
        $this->policy['index'] = $IndexPolicy;

        return $this;
    }

    /**
     * Set showpolicy
     *
     * @param  bool  $ShowPolicy  Showpolicy
     *
     * @return  self
     */
    private function setShowPolicy(bool $ShowPolicy)
    {
        $this->policy['show'] = $ShowPolicy;

        return $this;
    }

    /**
     * Set editpolicy
     *
     * @param  bool  $EditPolicy  Editpolicy
     *
     * @return  self
     */
    private function setEditPolicy(bool $EditPolicy)
    {
        $this->policy['edit'] = $EditPolicy;

        return $this;
    }

    /**
     * Set updatepolicy
     *
     * @param  bool  $UpdatePolicy  Updatepolicy
     *
     * @return  self
     */
    private function setUpdatePolicy(bool $UpdatePolicy)
    {
        $this->policy['update'] = $UpdatePolicy;

        return $this;
    }

    /**
     * Set createpolicy
     *
     * @param  bool  $CreatePolicy  Createpolicy
     *
     * @return  self
     */
    private function setCreatePolicy(bool $CreatePolicy)
    {
        $this->policy['create'] = $CreatePolicy;

        return $this;
    }

    /**
     * Set storepolicy
     *
     * @param  bool  $StorePolicy  Storepolicy
     *
     * @return  self
     */
    private function setStorePolicy(bool $StorePolicy)
    {
        $this->policy['store'] = $StorePolicy;

        return $this;
    }

    /**
     * Set destroypolicy
     *
     * @param  bool  $DestroyPolicy  Destroypolicy
     *
     * @return  self
     */
    private function setDestroyPolicy(bool $DestroyPolicy)
    {
        $this->policy['destroy'] = $DestroyPolicy;

        return $this;
    }

    /**
     * Set forceDeletepolicy
     *
     * @param  bool  $ForceDeletePolicy  ForceDeletepolicy
     *
     * @return  self
     */
    private function setForceDeletePolicy(bool $ForceDeletePolicy)
    {
        $this->policy['forceDelete'] = $ForceDeletePolicy;

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
    private function setCurrentMethod(string $currentMethod)
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
     * Get all methods
     *
     * @return  array
     */
    public function getAllMethods()
    {
        return $this->allMethods;
    }


    /**
     * Get methods with views
     *
     * @return  array
     */
    public function getRequiresModel()
    {
        return $this->requiresModel;
    }

    /**
     * Get requires multiple models
     *
     * @return  array
     */
    public function getMultipleModel()
    {
        return $this->multipleModel;
    }

    /**
     * Get requires single models
     *
     * @return  array
     */
    public function getSingleModel()
    {
        return $this->singleModel;
    }

    /**
     * Get related models
     *
     * @return  array
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * Set related models
     *
     * @param  array  $related  Related models
     *
     * @return  self
     */
    private function setRelated(array $related)
    {
        $this->related = $related;

        return $this;
    }

    /**
     * Get current method's parameters
     *
     * @return  array
     */
    public function getMethodParameters(int $key = null)
    {
        if($key){
            return $this->methodParameters[$key];
        }
        return $this->methodParameters;
    }

    /**
     * Set current method's parameters
     *
     * @param  array  $methodParameters  Current method's parameters
     *
     * @return  self
     */
    public function setMethodParameters(array $methodParameters)
    {
        $this->methodParameters = $methodParameters;

        return $this;
    }

    /**
     * Set methods with views
     *
     * @param  array  $viewMethods  Methods with views
     *
     * @return  self
     */
    private function setViewMethods(array $viewMethods)
    {
        $this->viewMethods = $viewMethods;

        return $this;
    }

    /**
     * Get form request validator
     *
     * @return  string
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set form request validator
     *
     * @param  string  $validator  Form request validator
     *
     * @return  self
     */
    private function setValidator(string $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get allowed methods
     *
     * @return  array
     */
    public function getAllowedMethods()
    {
        return $this->allowedMethods;
    }

    /**
     * Set allowed methods
     *
     * @param  array  $allowedMethods  Allowed methods
     *
     * @return  self
     */
    private function setAllowedMethods(array $allowedMethods)
    {
        $this->allowedMethods = $allowedMethods;

        return $this;
    }

    /**
     * Get not allowed methods
     *
     * @return  array
     */
    public function getNotAllowedMethods()
    {
        return $this->notAllowedMethods;
    }

    /**
     * Set not allowed methods
     *
     * @param  array  $notAllowedMethods  Not allowed methods
     *
     * @return  self
     */
    private function setNotAllowedMethods(array $notAllowedMethods)
    {
        $this->notAllowedMethods = $notAllowedMethods;

        return $this;
    }

    /**
     * Get requires no models
     *
     * @return  array
     */
    public function getNoModel()
    {
        return $this->noModel;
    }

    /**
     * Get current method that requires model
     *
     * @return  boolean|null
     */
    public function getCurrentRequiresModel()
    {
        return $this->currentRequiresModel;
    }

    /**
     * Set current method that requires model
     *
     * @param  boolean|null  $currentRequiresModel  Current method that requires model
     *
     * @return  self
     */
    private function setCurrentRequiresModel(bool $currentRequiresModel)
    {
        $this->currentRequiresModel = $currentRequiresModel;

        return $this;
    }

    /**
     * Get additional models displayed to end-users
     *
     * @return  array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * Set additional models displayed to end-users
     *
     * @param  array  $extra  Additional models displayed to end-users
     *
     * @return  self
     */
    public function setExtra(array $extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get form request validation rules
     *
     * @return  array
     */
    public function getValidationRules()
    {
        return $this->validationRules;
    }

    /**
     * Set form request validation rules
     *
     * @param  array  $validationRules  Form request validation rules
     *
     * @return  self
     */
    public function setValidationRules(array $validationRules)
    {
        // check if array
        foreach($validationRules as $key => $value){
            if(!is_array($value)){
                throw new Exception("The key '$key' in ValidationRules array is expected to be an array!");
            }else{
                if($key === "create" || $key === "edit" || $key === "rules"){
                    foreach($value as $sub => $subValue){
                        if (!is_array($subValue)) {
                            throw new Exception("The key '$sub' in ValidationRules array is expected to be an array!");
                        }else{
                            if($sub === "rules"){

                                foreach($subValue as $field => $test){
                                    if (!is_array($test)) {
                                        throw new Exception("The key '$field' in ValidationRules array is expected to be an array!");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // parse user's rules and required
        foreach ($this->validationRules as $key => $type) {
            if (key_exists($key, $validationRules)) {
                // merge user's validation rules and required list
                $this->validationRules[$key] = array_merge($this->validationRules[$key], $validationRules[$key]);
            }

            // merge general validation rules list
            if (key_exists('rules', $validationRules)) {
                $this->validationRules[$key]['rules'] = array_merge($this->validationRules[$key]['rules'], $validationRules['rules']);
            }

            // merge general validation required list
            if (key_exists('required', $validationRules)) {
                $this->validationRules[$key]['required'] = array_merge($this->validationRules[$key]['required'], $validationRules['required']);
            }
        }

        return $this;
    }

    /**
     * Get methods that requires validation
     *
     * @return  array
     */
    public function getRequiresValidation()
    {
        return $this->requiresValidation;
    }

    /**
     * Set methods that requires validation
     *
     * @param  array  $requiresValidation  Methods that requires validation
     *
     * @return  self
     */
    public function setRequiresValidation(array $requiresValidation)
    {
        $this->requiresValidation = $requiresValidation;

        return $this;
    }

    /**
     * Get instance of @link Illuminate\Http\Request
     *
     * @return  Illuminate\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set instance of @link Illuminate\Http\Request
     *
     * @param  Illuminate\Http\Request  $request  Instance of @link Illuminate\Http\Request
     *
     * @return  self
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get router
     *
     * @return  Illuminate\Routing\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Set router
     *
     * @param  Illuminate\Routing\Router  $router  Router
     *
     * @return  self
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Get fields to be stored in storage
     *
     * @return  array
     */
    public function getStoreFields()
    {
        return $this->storeFields;
    }

    /**
     * Set fields to be stored in storage
     *
     * @param  array  $storeFields  Fields to be stored in storage
     *
     * @return  self
     */
    public function setStoreFields(array $storeFields)
    {
        $this->storeFields = $storeFields;

        return $this;
    }

    /**
     * Get paths to store different files
     *
     * @return  array
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * Set paths to store different files
     *
     * @param  array  $storagePath  Paths to store different files
     *
     * @return  self
     */
    public function setStoragePath(array $storagePath)
    {
        $this->storagePath = $storagePath;

        return $this;
    }

    /**
     * Get return redirect after completion
     *
     * @return  array
     */
    public function getRedirect(string $method = null)
    {
        if($method){
            return $this->redirect[$method];
        }
        return $this->redirect;
    }

    /**
     * Set return redirect after completion
     *
     * @param  array  $redirect  Return redirect after completion
     *
     * @return  self
     */
    public function setRedirect(array $redirect)
    {
        foreach ($this->redirect as $key => $value) {
            if (key_exists($key, $redirect)) {
                $this->redirect[$key] = $redirect[$key];
            }
        }

        return $this;
    }

    /**
     * Get user created methods (outside the default laravel methods)
     *
     * @return  array
     */
    public function getUserMethods()
    {
        return $this->userMethods;
    }

    /**
     * Set user created methods (outside the default laravel methods)
     *
     * @param  array  $userMethods  User created methods (outside the default laravel methods)
     *
     * @return  self
     */
    public function setUserMethods(array $userMethods)
    {
        $this->userMethods = $userMethods;

        return $this;
    }
}
