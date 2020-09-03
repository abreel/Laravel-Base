<?php

namespace App\Base\Traits;


use App\Providers\CategoryDeleted;
use Illuminate\Support\Str;

/**
 * Delete and move sub categories/related to default
 */
trait SubRelatedDelete
{
    protected $EventDirectory = "App\Providers\\";

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->model::findOrFail($id);
        if ($model->default) {
            return back();
        }

        $lowerName = Str::lower($this->name);
        $upperName = Str::upper($this->name);
        $titleName = Str::title($this->name);

        // fetch model products
        $related = $model->related()->get();

        // set event directory
        $deletedEvent = $this->EventDirectory.$titleName.'Deleted';

        // move products to default model
        event(new $deletedEvent($related));


        // delete model
        $model->delete();

        return redirect()
            ->route(Str::lower($this->name).".index")
            ->with([
                "status" => true,
                "status_message" => "$titleName deleted, resources under this $lowerName will be automatically moved to the default $lowerName. This might take some time. Please be patient.",
            ]);
    }
}
