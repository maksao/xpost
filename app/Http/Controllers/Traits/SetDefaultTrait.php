<?php

namespace App\Http\Controllers\Traits;

use App\Helpers;

trait SetDefaultTrait
{

    /**
     * @param $model
     * @param null $parent - родительская модель
     */
    public function setDefaultFor($model, $parent = null)
    {
        $this->authorize('set_default', $model);

        $model->when($parent, function($q) use ($parent) {
            $q->where(str_singular($parent->getTable()).'_id', $parent->id);
        })->where('is_default', 'Y')->update(['is_default'=>'N']);

        $model->update(['is_default'=>'Y']);

        Helpers::setHL($model->id);
    }
}