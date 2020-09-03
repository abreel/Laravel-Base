<?php

namespace App\Base\Http\Controllers;

use App\ControllerEditor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BaseControllerEditor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $models = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        // return view('base.index', compact('models'));
        return view('base.index', ['models' => DB::connection()->getDoctrineSchemaManager()->listTableNames()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $model
     * @return \Illuminate\Http\Response
     */
    public function show($model)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($model)
    {
        return view('base.edit', [
            'name' => $model,
            'studlyName' => Str::studly($model),
            'model' => DB::table('controller_editor_model_settings')->where('model', $model)
            ]);
    }

    /**
     * Show the form for editing the specified resource's setting
     *
     * @param  string  $model
     * @return \Illuminate\Http\Response
     */
    public function editSetting($model)
    {
        // get an instance of the model's controller
        $controller = $model . 'Controller';
        dd(resolve($controller));

        // if controller does not exist, give an error

        // if controller exists display settings
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $model)
    {
        $data = $request->validate([
            'table' => 'required|string',
            'model' => 'required|string',
            'controller' => 'required|string',
        ]);


        // check if the model exists
        $model = DB::where('model', $model)->first();

        // if it does, update the controller field
        if($model){
            $model->controller = $data['controller'];
            $model->save();
        }

        // if it doesn't, create required fields
        else {
            ControllerEditor::create($data);
        }

        return redirect()
            ->route('controllerEditor.index')
            ->with(['status' => true, 'responseMessage' => 'Model updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($model)
    {
        //
    }
}
