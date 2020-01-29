<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Helpers;
use App\Jobs\PricelistUploadJob;
use App\Price;
use App\Pricelist;
use App\Product;
use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class PricelistController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Прайслисты',
            'breadcrumbs' => Breadcrumbs::render(),
            'pricelists' => Pricelist::withCount('prices')->orderBy('name')->get()
        ];

        return view('pricelists.index', $data);
    }

    public function show(Pricelist $pricelist)
    {
        $this->setFilter('pricelist_prices');

        $data = [
            'page_title' => 'Прайслист: '.$pricelist->name,
            'breadcrumbs' => Breadcrumbs::render(),
            'pricelist' => $pricelist,
            'prices' => $this->applyPricesFilters($pricelist->prices())->paginate(25)->withPath($this->getURLWithFilters('pricelist_prices')),
            'nullBrandsCount' => $pricelist->prices()->whereNull('brand_id')->groupBy('brand_name')->count(),
            'nullProductsCount' => $pricelist->prices()->whereNull('product_id')->count(),
            'brands' => Brand::orderBy('name')->get()
        ];

        return view('pricelists.show', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => Rule::unique('pricelists'),
        ]);

        $pl = Pricelist::create($request->all());

        Helpers::setHL($pl);

        return back()->withNoticeSuccess(__('messages.db.record_created'));
    }

    public function upload(Request $request, Pricelist $pricelist)
    {
        $this->authorize('upload', $pricelist);

        $this->validate($request, [
            'userfile' => 'required|mimes:xlsx,xls'
        ]);

        $request->file('userfile')->storeAs('','pricelist'.$pricelist->id.'.xlsx', 'imports');

        $job_data = [
            'user_id' => \Auth::id(),
            'pricelist_id' => $pricelist->id,
        ];

        PricelistUploadJob::dispatch($job_data);

        $pricelist->update(['status'=>1]);

        return back()->withNoticeSuccess(__('Файл отправлен на загрузку'));
    }

    // перепроверка Брендов
    public function brands(Pricelist $pricelist)
    {
        $brands = $pricelist->prices()
            ->select('brand_name')
            ->whereNull('brand_id')
            ->groupBy('brand_name')
            ->pluck('brand_name')
            ->toArray();
        foreach ($brands as $brand){
            Price::where('brand_name',$brand)->update(['brand_id' => Brand::getIdByName($brand)]);
        }
        return back()->withNoticeSuccess(__('Бренды перепроверены'));
    }

    // перепроверка товара
    public function products(Pricelist $pricelist)
    {
        $pricelist_products = $pricelist->prices()->select(['id','article','brand_id','product_id'])
            ->whereNull('product_id')
            ->whereNotNull('brand_id')
            ->get();
        foreach ($pricelist_products as $pl_product){
            $pl_product->update(['product_id' => Product::getByArticleAndBrand($pl_product->article, $pl_product->brand_id, true)]);
        }
        return back()->withNoticeSuccess(__('Товар в позициях перепроверен'));
    }

    public function clear(Pricelist $pricelist)
    {
        $pricelist->prices()->delete();
        $pricelist->setLog('Прайслист очищен');
        return back()->withNoticeSuccess(__('Прайслист очищен'));
    }

    public function togglePriceFlag(Price $price, $flag)
    {
        $price->toggleFlag('is_'.$flag);
    }

    public function cancelJob(Pricelist $pricelist)
    {
        $pricelist->setStatus(0);
        return back()->withNoticeSuccess('Задача сброшена');
    }

    public function destroy(Pricelist $pricelist)
    {
        $pricelist->delete();
        return back()->withNoticeSuccess(__('messages.db.record_deleted'));
    }

    public function updateField(Request $request, Pricelist $pricelist)
    {
        Validator::make($request->all(), [
            'name' => [
                'sometimes',
                Rule::unique('pricelists')->ignore($pricelist->id)
            ],
        ])->validate();

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $pricelist) ) {
            $pricelist->setLogs($logs);
            $pricelist->update($request->all());
        }

        if(!$request->ajax()){
            return back()->withNoticeSuccess(__('messages.db.record_updated'));
        }
    }

    public function updatePriceField(Request $request, Price $price)
    {
//        Validator::make($request->all(), [
//            'name' => [
//                'sometimes',
//                Rule::unique('pricelists')->ignore($pricelist->id)
//            ],
//        ])->validate();

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $price) ) {
            $price->setLogs($logs);
            $price->update($request->all());
        }

        if(!$request->ajax()){
            return back()->withNoticeSuccess(__('messages.db.record_updated'));
        }
    }

    // Добавляет к запросу фильтры
    public function applyPricesFilters($q, $sortField='id', $sortDir='ASC')
    {

        // ID
        if(request('id')){
            $q->where('id', request('id'));
            return $q;
        }

        // Имя
        if(request('name')){
            $q->where('name', 'like', '%' . request('name') . '%');
        }

        // Артикул
        if(request('article')){
            $article = Product::fixArticle(request('article'));
            $q->where('article_fixed', 'like', '%'.$article.'%');
        }

        // Бренд
        if(request('brand')){
            $q->where('brand_id', request('brand'));
        }

        // Бренд ОК
        if(request('brand_id')){
            if(request('brand_id') == 'Y') {
                $q->whereNotNull('brand_id');
            } else {
                $q->whereNull('brand_id');
            }
        }

        // Товар ОК
        if(request('product_id')){
            if(request('product_id') == 'Y') {
                $q->whereNotNull('product_id');
            } else {
                $q->whereNull('product_id');
            }
        }

        // Сортировка

        if(request('sort')){
            $dir = request('sort_dir') == 'd' ? 'DESC' : 'ASC';
            $q->orderBy(request('sort'), $dir);
        } else {
            $q->orderBy($sortField, $sortDir);
        }

        return $q;
    }
}
