<?php
/**
 * @see App\Base\Contracts\ViewMethod for [create, show, index, edit] methods
 * @see App\Base\Contracts\StorageMethod for [update, store] methods
 * @see App\Base\Contracts\DeleteMethod for [destroy, forceDelete] methods
 */

namespace App\Base\Contracts;

interface ControllerContract
{
    /**
     * Process request
     *
     * @param array $parameters
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function process(array $parameters);
}
