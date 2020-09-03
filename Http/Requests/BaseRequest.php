<?php

namespace App\Base\Http\Requests;

use Exception;
use App\Base\Base;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request as MainRequest;

// class BaseRequest extends FormRequest
class BaseRequest
{
    use Rules;

    /**
     * Instance of @link Illuminate\Http\Request
     *
     * @var Illuminate\Http\Request
     */
    public $mainRequest;

    /**
     * Instance of @link App\Base\Base
     *
     * @var App\Base\Base
     */
    protected $base;

    /**
     * Instatiate required classes
     *
     * @param Illuminate\Http\Request $mainRequest
     */
    public function __construct(MainRequest $mainRequest, Base $base)
    {
        // parent::__construct();
        $this->mainRequest = $mainRequest;
        $this->base = $base;
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

        if(!$rules){
            return false;
        }

        // merge required
        if(!is_array($rules)){
            throw new Exception("Array expected as rules");
        }

        foreach ($rules as $key => $value) {

            // if required
            if (array_search($key, $userValidation['required'])) {
                if(!array_search('required', $value)) {
                    $rules[$key] = array_merge($value, ['required']);
                }
            }

            // if not required
            else if(!array_search('required', $value) && !array_search('nullable', $value)){
                    $rules[$key] = array_merge($value, ['nullable']);
            }
        }

        return $rules;
    }

    /**
     * Fetch rules for current request
     *
     * @return array|void
     */
    public function fetchRequestRules()
    {
        if (($this->mainRequest->all())) {
            return array_intersect_key($this->rules, $this->mainRequest->all());
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
        $rules = $this->base->getValidationRules();

        // current method
        $currentMethod = $this->base->getCurrentMethod();

        // store method
        if($currentMethod === "store"){
            return $rules['store'];
        }

        // update method
        else if($currentMethod === "update") {
            return $rules['update'];
        }

        else {
            return false;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // return $this->processRules();

        // TODO: Delete next lines
        // return [
        //     'name' => 'required',
        //     'description' => 'required',
        //     'image' => 'required',
        //     'file' => 'required|array|file',
        // ];

        $validator = Validator::make($this->mainRequest->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        dd($validator);

        if ($validator->fails()) {
            return redirect('post/create')
            ->withErrors($validator)
                ->withInput();
        }
    }
}
