<?php

namespace App\Base\Http\Controllers;

use Illuminate\Support\Str;
// use Illuminate\Http\Request;
use App\Traits\SubRelatedDelete;
use App\Base\Http\Requests\Request;

class DescriptionRequestController extends BaseController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  Description  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if model policy is strict
        $this->strict || $this->strictCreate
            ? auth()->user()->hasPermission('add_' . $this->pluralName)
            : '';

        $this->authorize('create', $this->model);
        // dd($request->all());
        $data = $request->validated();
        // dd("I am here");
        dd($data);

        if (isset($data['image']) && $data['image']) {
            // store the image
            $imagePath = request('image')->store("img/$this->pluralName", 'public');

            // Override the image in the request array
            $data = array_merge($data, [
                'image' => $imagePath,
            ]);
        }

        // if user set this as default
        if (isset($data["default"]) && $data["default"]) {
            // set the previous default to false
            $prev = $this->model::where("default", true)->get()->first();

            // if there was a previous default
            if ($prev) {
                $prev->default = false;
                $prev->save();
            }
        }


        $this->model::create($data);

        return redirect()
            ->route("$this->name.index")
            ->with([
                "status" => true,
                "status_message" => Str::title($this->name) . " created",
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // if model policy is strict
        $this->strict || $this->strictCreate
            ? auth()->user()->hasPermission('edit_' . $this->pluralName)
            : '';

        $this->authorize('update', $this->model);
        $data = $request->validated();

        $model = $this->model::findOrFail($id);

        $model->name = $data["name"];
        $model->short_description = $data["short_description"];
        $model->full_description = $data["full_description"];

        if (isset($data['image']) && $data['image']) {
            // store the image
            $imagePath = request('image')->store("img/$this->pluralName", 'public');
            // store the image path in the database
            $model->image = $imagePath;
        }

        if (isset($data["default"]) && $data["default"]) {
            // set the previous default to false
            $prev = $this->model::where("default", true)->get()->first();

            // if there was a previous default
            if ($prev) {
                $prev->default = false;
                $prev->save();
            }

            // set new default
            $model->default = true;
        }

        $model->save();

        return redirect()
            ->route("$this->name.show", $model->id)
            ->with([
                "status" => true,
                "status_message" => Str::title($this->name) . " updated",
            ]);
    }
}
