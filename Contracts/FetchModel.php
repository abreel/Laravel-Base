<?php

namespace App\Base\Contracts;

use Exception;
use App\Base\Base;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FetchModel
{
    /**
     * Instance of Base class
     *
     * @var App\Base\Base
     */
    private $base;

    /**
     * Short-term string storage
     *
     * @var mixed
     */
    private $value;

    /**
     * Requires model
     *
     * @var boolean
     */
    private $requiresModel = false;

    /**
     * Initialize contract
     *
     * @param App\Base\Base $base
     */
    public function __construct(Base $base)
    {
        $this->base = $base;
    }

    /**
     * Requires model
     *
     * @return boolean
     */
    public function required()
    {
        // requires model
        if (in_array($this->base->getCurrentMethod(), $this->base->getRequiresModel())) {
            $this->requiresModel = true;
            return true;
        }

        // doesn't require model, but has related
        if (!empty($this->base->getRelated())) {
            return true;
        }

        // but has extra models
        if (!empty($this->base->getExtra())) {
            return true;
        }
        return false;
    }

    /**
     * Requires related
     *
     * @param string $type  - array or string
     *
     * @return boolean|string
     */
    public function related(string $type)
    {
        // check for related
        if(empty($this->base->getRelated())){
            return false;
        }

        $count = 0;

        // unknown type
        // TODO: Delete the unused line of the two 'if' lines below
        // if($type !== "array" && $type !== "string"){
        if($type !== "string"){
            throw new Exception("Unknown expected related type of '$type'");
        }

        // TODO: Left for backtracking, in case of errors
        // // if type is array
        // if($type === "array"){
        //     $related = [];
        //     foreach ($this->base->getRelated() as $field => $value) {
        //         $count++;

        //         $related[] = $value;
        //     }
        // }

        // if type is string
        if($type === "string"){
            $related = '';
            $newArray = [];
            foreach ($this->base->getRelated() as $field => $value) {
                $count++;

                $newArray[] = $value['table'];
            }

            $related = $this->base->arrayToString($newArray);
        }

        return $related;
    }

    public function extractWhere(array $array)
    {
        $newArray = collect($array)->collapse();

        foreach ($newArray as $key => $value) {
            if(is_array($value)){
                throw new Exception("Two (2) layer array expected, deeply nested array found. Please keep your 'where' declaration array to of two layers.");
            }
        }
        return $newArray;
        // return "where('".$newArray['column']. "', '" . $newArray['operator'] . "', '" . $newArray['value'] . "')";
    }

    /**
     * Fetch any extra required models
     *
     * @return \Illuminate\Support\Collection|boolean
     */
    public function fetchExtra()
    {
        if(empty($this->base->getExtra())){
            return false;
        }

        $extraName = $this->base->extractAfterBackslash($this->base->getExtra(), 'table');

        //  make sure extra model list is not empty
        if(count($extraName) < 1){
            throw new Exception("Unexpected empty extra model array.");
        }

        // only one extra model
        if(count($extraName) === 1){

            if(key_exists('where', $this->base->getExtra()[0])){
                $where = $this->extractWhere($this->base->getExtra()[0]['where']);
                $model = DB::table($this->base->lowercasePlural($extraName[0]))
                    ->where($where['column'], $where['operator'], $where['value'])
                    ->get();
            }

            else{
                $model = DB::table($this->base->lowercasePlural($extraName[0]))->get();
            }
        }

        // multiple extra models
        if(count($extraName) > 1){
            foreach ($this->base->getExtra() as $field => $value) {

                if (key_exists('where', $value)) {
                    $this->value = $value;
                    $newModel = DB::table($this->base->lowercasePlural($extraName[0]))
                        ->where(function ($query){
                            $where = $this->extractWhere($this->value['where']);
                            for ($i=0; $i < count($where); $i++) {
                                $query->where($where['column'], $where['operator'], $where['value']);
                            }
                        })
                        ->get();
                } else {
                    $newModel = DB::table($this->base->lowercasePlural($extraName[0]))->get();
                }
                $field === 0
                    ? $model[] = $newModel
                    : $model[] = array_push($model, $newModel);
            }
            $model = collect($model)->collapse();
        }
        return $model;
    }

    /**
     * Fetch required models
     *
     * @return mixed
     */
    public function fetch()
    {
        // single
        if($this->base->length() === 'single'){
            $id = $this->base->getMethodParameters()[0];

            $model = $this->related('string')
                    ? $this->base->getModel()::findOrFail($id)->with($this->related('string'))
                    : $this->base->getModel()::findOrFail($id);

            $extra = $this->fetchExtra();
        }

        // multiple
        else if($this->base->length() === 'multiple'){
            $model = $this->related('string')
                ? $this->base->getModel()::orderByDesc('updated_at')
                        ->with($this->related('string'))
                        ->paginate(config('dec-base.paginationLimit', 15))

                : $this->base->getModel()::orderByDesc('updated_at')
                    ->paginate(config('dec-base.paginationLimit', 15));

            $extra = $this->fetchExtra();
        }

        // none
        else if($this->base->length() === 'none'){
            $model = false;
            $extra = $this->fetchExtra();
        }

        else{
            throw new Exception("Model definition and it's related not processable.", 1);
        }
        
        return [
            'model' => $model,
            'extra' => $extra
        ];
    }

    /**
     * Returns result
     *
     * @return mixed
     */
    public function process()
    {
        return $this->fetch();
    }
}
