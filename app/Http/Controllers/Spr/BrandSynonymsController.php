<?php

namespace App\Http\Controllers\Spr;

use App\Brand;
use App\BrandSynonym;
use App\Helpers;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandSynonymsController extends Controller
{
    public function index(Brand $brand)
    {
        $data = [
            'page_title' => 'Синонимы бренда: '.$brand->name,
            'breadcrumbs' => Breadcrumbs::render(),
            'brand' => $brand,
            'synonyms' => $brand->synonyms()->orderBy('name')->get()
        ];
        return view('spr.brands.synonyms', $data);
    }

    public function store(Request $request, Brand $brand)
    {
        $request->merge([
            'name' => trim(mb_strtolower($request->get('name')))
        ]);

        $this->validate($request, [
            'name' => 'required|unique:brand_synonyms,name'
        ]);

        $result = $brand->synonyms()->create($request->all());
        Helpers::setHL($result);

        return back()->withNoticeSuccess('Синоним добавлен');
    }

    public function destroy(Brand $brand, BrandSynonym $synonym)
    {
        $synonym->delete();
        $brand->setLog('Удален синоним "'.$synonym->name.'"');
        return back()->withNoticeSuccess('Запись удалена');
    }
}
