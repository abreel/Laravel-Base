<?php

namespace App\Base;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Routing\Router;
use App\Base\Traits\GettersAndSetters;
use Illuminate\Http\Request;

class Base
{
    use GettersAndSetters;

    /**
     * Set defaults
     *
     * @param Illuminate\Routing\Router $router
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Router $router, Request $request)
    {
        return $this->setDefault($router, $request);
    }

    /**
     * Process rules for current request
     *
     * @return boolean|array
     */
    public function processRules()
    {
        $userValidation = $this->fetchUserRules();

        // merge rules
        $rules = array_merge($this->fetchRequestRules(), $userValidation['rules']);

        if (!$rules) {
            return false;
        }

        // merge required
        if (!is_array($rules)) {
            throw new Exception("Array expected as rules");
        }

        foreach ($rules as $key => $value) {
            // if required
            if (array_search($key, $userValidation['required'])) {
                if (!array_search('required', $value)) {
                    $rules[$key] = array_merge($value, ['required']);
                }
            }

            // if not required
            else if (!array_search('required', $value) && !array_search('nullable', $value)) {
                $rules[$key] = array_merge($value, ['nullable']);
            }
        }

        return $rules;
    }

    /**
     * Set defualts
     *
     * @param  string  $name  defualts
     *
     * @return  self
     */
    private function setDefault(Router $router, Request $request)
    {
        $name = substr(
            $router->currentRouteName(),
            0,
            strpos($router->currentRouteName(), '.')
        );

        $method = substr(
            $router->currentRouteName(),
            strpos(
                $router->currentRouteName(),
                '.'
            ) + 1
        );

        $this->setRequest($request);
        $this->setRouter($router);
        $this->setName($name);
        $this->setCurrentMethod($method);
        $this->setModel('App\\'.Str::studly($name));
        $this->setPluralName($name);
        $this->setViewsFolder($this->pluralName);

        return $this;
    }

    /**
     * Parse setting
     *
     * @param array $setting
     * @return void
     */
    private function parseSetting(array $setting)
    {
        foreach ($setting as $field => $value) {
            if(!in_array($field, $this->settings)){
                throw new Exception("Unknown setting type '$field'");
            }

            $setter = 'Set'.$field;
            $this->$setter($value);
        }
        return;
    }

    /**
     * Resolve developer's setting
     *
     * @param array $setting
     * @return void
     */
    public function setting(array $setting)
    {
        if(empty($setting)){
            return;
        }

        return $this->parseSetting($setting);
    }

    /**
     * Update model
     *
     * @param array $data
     * @return void
     */
    public function updateModel(array $data)
    {
        $model = $this->getModel()::findOrFail($this->getMethodParameters(0))->first();

        $data = $this->storeFile($data);

        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        return $model->save();
    }

    /**
     * Store model
     *
     * @param array $data
     * @return void
     */
    public function storeModel(array $data)
    {
        return $this->getModel()::create($this->storeFile($data));
    }

    public static function routes ()
    {
        return __DIR__ . '/routes/base.php';
    }

    /**
     * Store files using required driver
     *
     * @param array $data
     * @param string $storagePath
     * @param string $driver    ['public', 's3', e.t.c.]
     * @return void
     */
    public function storeFile(array $data = null, string $storagePath = null, string $driver = null)
    {
        if (!$data) {
            $data = $this->request->all();
        }

        if (!$storagePath) {
            $storagePath = $this->getStoragePath();
        }

        if (!$driver) {
            $driver = config('dec-base.fileStorageDriver', 'public');
        }

        foreach ($this->getStoreFields() as $key => $value) {
            if (key_exists($value, $data)) {
                $field = $data[$value];

                if (!key_exists($value, $storagePath)) {
                    $storagePath[$value] = $this->getName() . '/' . $value;
                }

                // store field
                $path = $field->store($storagePath[$value], $driver);

                $data[$value] = $path;
            }
        }

        return $data;
    }

    /**
     * Redirect to a route with a message
     *
     * @param boolean $back redirect to previous location
     * @param string $route route name [e.g. base.index]
     * @param mixed $message    message to be sent
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function baseRedirect(bool $back = false, string $route = null, $message = null)
    {
        if(!$route){
            $route = "$this->name . index";
        }

        if($back){
            return $message ? back()->with($message) : back();
        }

        return $message
            ? redirect()
                ->route($route)
                ->with($message)
            : redirect()->route($route);
    }

    /**
     * Status message
     *
     * @param string $name
     * @param string $message
     * @param string $statusName
     * @param boolean $status
     * @return array
     */
    public function statusMessage(string $name = null, string $message = null, string $statusName = null, bool $status = true)
    {
        if (!$name) {
            $name = $this->name;
        }

        if (!$statusName) {
            $statusName = $this->name . "_" . $this->currentMethod;
        }

        if (!$message  && $status) {
            $message = Str::title($this->name) . " " . $this->currentMethod . " operation completed.";
        }

        return [
            $name => $name,
            $statusName . "_status" => $status,
            $statusName . "_message" => $message ? $message : '',
        ];
    }

    /**
     * Extracts string after last backward slash
     *
     * @param array $array
     * @param string $key
     *
     * @return array
     */
    public function extractAfterBackslash(array $array, string $key = 'name')
    {
        // make sure array is not empty
        if (empty($array)) {
            throw new Exception("Unexpected empty array", 1);
        }

        // extract
        $processed = [];

        foreach ($array as $field => $value) {
            // Extract related model name
            $processed[] = substr(
                $value[$key],
                strripos(
                    $value[$key],
                    '\\'
                ) + 1
            );
        }
        return $processed;
    }

    /**
     * Extracts field
     *
     * @param array $array
     * @param string $name
     *
     * @return array
     */
    public function extractField(array $array, string $name = 'name')
    {
        // make sure array is not empty
        if (empty($array)) {
            throw new Exception("Unexpected empty array");
        }

        // extract
        $processed = [];

        foreach ($array as $field => $value) {
            // Extract related model name
            $processed[] = $value[$name];
        }
        return $processed;
    }

    /**
     * length of required model
     *
     * @return string
     */
    public function length()
    {
        // requires single model
        if (in_array($this->currentMethod, $this->singleModel)) {
            return "single";
        }

        // requires multiple models
        if (in_array($this->currentMethod, $this->multipleModel)) {
            return "multiple";
        }

        // requires no model
        if (in_array($this->currentMethod, $this->noModel)) {
            return "none";
        }

        throw new Exception("Problem getting model's required length", 1);
    }

    /**
     * Convert array to string
     *
     * @param array $array
     * @param string $seperator
     * @param boolean $spaceBetween
     *
     * @return string
     */
    public function arrayToString(array $array, string $seperator = ',', bool $spaceBetween = true)
    {
        $count = 0;
        $string = '';
        foreach ($array as $field => $value) {
            $count++;

            $string .= $value;
            if(count($array) > $count){
                $string .= $spaceBetween
                    ? $seperator.' '
                    : $seperator;
            }
        }

        return $string;
    }

    /**
     * convert string to lowercase plural
     *
     * @param string $string
     * @return string
     */
    public function lowercasePlural(string $string)
    {
        // convert to lowercase plural
        return Str::lower(Str::plural($string));
    }

    /**
     * Generate slug with text
     *
     * @param string $seperator underscore(_) or hyphen(-), symbol or text
     * @param string $text text
     * @param string|null $extraText additional text
     * @param boolean $before   Put additional text before text
     * @return string
     */
    public function slug(string $seperator = "underscore", string $text = null, string $extraText = null, bool $before = true)
    {

        if ($text === null) {
            $name = $this->getPluralName();
        }
        // if additional text
        if ($extraText) {
            $text = $before
                ? $extraText . ' ' . $text
                : $text . ' ' . $extraText;
        }

        if ($seperator === "hyphen" || $seperator === '-') {
            return Str::slug($text, '-');
        }

        if ($seperator === "underscore" || $seperator === '_') {
            return Str::slug($text, '_');
        }
    }

}
