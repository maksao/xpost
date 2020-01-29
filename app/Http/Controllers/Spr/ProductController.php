<?php

namespace App\Http\Controllers\Spr;

use App\Brand;
use App\Helpers;
use App\Jobs\ProductsUploadJob;
use App\Product;
use Breadcrumbs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Storage;
use Validator;

class ProductController extends Controller
{
    public $filterName = Product::OBJECT_CODE;

    public function index()
    {
        $this->setFilter();

        $data = [
            'page_title' => 'Товар',
            'breadcrumbs' => Breadcrumbs::render(),
            'products' => $this->applyFilters(Product::select(), 'name_rus')->with('brand')->paginate(25)->withPath($this->getURLWithFilters()),
            'brands' => Brand::withCount('products')->orderBy('name')->get(),
        ];
        //dd(\request()->getQueryString());
        return view('spr.products.index', $data);
    }

    public function store(Request $request)
    {
        $this->createProduct($request);
        return back()->withNoticeSuccess(__('messages.db.record_created'));
    }

    // Выделяем создание товара в отдельный метод т.к. товар будет добавляться из разных контроллеров
    public function createProduct(Request $request)
    {
        $request->merge([
            'article_fixed' => Product::fixArticle($request->article),
            'name_rus' => Product::fixName($request->name_rus),
            'name_eng' => Product::fixName($request->name_eng),
            'weight' => Helpers::normalizeFloat($request->weight),
        ]);

        $this->validate($request, [
            'brand_id' => 'required|exists:brands,id',
            'article' => Rule::unique('products')->where(function ($query) use ($request) {
                $query->where('brand_id', $request->brand_id);
            }),
            'name_rus' => 'required',
            'name_eng' => 'required',
            'weight' => 'nullable|regex:/^\d+(\.\d{1,3})?$/',
        ]);

        $product = Product::create($request->all());

        \App\Price::select(['id','article','brand_id','product_id'])
            ->where('article', (string)$product->article)
            ->where('brand_id', $product->brand_id)
            ->whereNull('product_id')
            ->update(['product_id'=>$product->id]);

        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name_rus' => 'required',
            'name_eng' => 'required',
        ]);

        $product->update($request->all());
        $product->setLog('Данные отредактированы');

        return back()->withNoticeSuccess(__('messages.db.record_updated'));
    }

    public function updateField(Request $request, Product $product)
    {

        Validator::make($request->all(), [
            'article' => [
                'sometimes',
                'filled',
                Rule::unique('products')->where(function ($query) use ($product) {
                    $query->where('brand_id', $product->brand_id);
                })
            ],
            'name_rus' => 'sometimes|filled',
            'name_eng' => 'sometimes|filled',
            'weight' => 'sometimes|regex:/^\d+(\.\d{1,3})?$/'
        ])->validate();

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $product) ) {
            $product->setLogs($logs);
            if($request->has('article')){
                $request->merge(['article_fixed'=>Product::fixArticle($request->article)]);
            }
            $product->update($request->all());
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->withNoticeSuccess(__('messages.db.record_deleted'));
    }

    public function upload(Request $request)
    {
        if(Storage::disk('imports')->exists('products.xlsx')){
            return back()->withNoticeError(__('Другой файл еще заргужается'));
        }

        $this->validate($request, [
            'userfile' => 'required|mimes:xlsx,xls'
        ]);

        $request->file('userfile')->storeAs('','products.xlsx', 'imports');

        ProductsUploadJob::dispatch($request->user()->id);

        return back()->withNoticeSuccess(__('Файл отправлен на загрузку'));

    }

    // Добавляет к запросу фильтры
    public function applyFilters($q, $sortField='id', $sortDir='ASC')
    {

        // ID
        if(request('id')){
            $q->where('id', request('id'));
            return $q;
        }

        // Имя
        if(request('name')){
            $q->where(function($q) {
                return $q->where('name_rus', 'like', '%' . request('name') . '%')
                    ->orWhere('name_eng', 'like', '%' . request('name') . '%');
            });
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
