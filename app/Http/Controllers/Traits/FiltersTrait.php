<?php

namespace App\Http\Controllers\Traits;

use App\Helpers;

trait FiltersTrait
{

    /**
     * Сохраняет фильтр в сессии
     */
    public function setFilter($filter_name = null)
    {
        if( !$filter_name ){
            $filter_name = $this->filterName;
        }
        if(!strlen($filter_name)){ abort(500, 'Не указано имя фильтра.'); }
        session(['filters.'.$filter_name => request()->getUri()] );
    }

    /**
     * Возвращает текущий фильтр
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public function getFilter($filter_name = null)
    {
        $filter = null;
        if( !$filter_name ){
            $filter_name = $this->filterName;
        }
        if(strlen($filter_name)){
            $filter = Helpers::getFilters($filter_name);
        }

        return $filter;
    }

    /**
     * Возвращает url для ссылок в постраничной навигации
     * @return null|string|string[]
     */
    public function getURLWithFilters($filter_name = null)
    {
        if( !$filter_name ){
            $filter_name = $this->filterName;
        }
        if(!strlen($filter_name)){ exit('Не указано имя фильтра.'); }
        return preg_replace('/[&]*page=[0-9]*/', '', $this->getFilter($filter_name));
    }
}