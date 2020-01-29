<?php

namespace App\Http\Controllers\Contractor;

use App\Brand;
use App\Helpers;
use App\Http\Controllers\Spr\BrandController;
use App\Http\Controllers\Spr\ProductController;
use App\Imports\OrderPositionsImport;
use App\Order;
use App\OrderPosition;
use App\OrderPositionStatus;
use App\OrderStatus;
use App\Price;
use App\Product;
use Arr;
use Breadcrumbs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class OrderPositionController extends Controller
{
    public $filterName = 'c.order-positions';

    /**
     * @param Order $order
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Order $order)
    {
        $this->authorize('view', $order);

        $this->setFilter();

        $data = [
            'page_title' => 'Заказ ' . $order->number,
            'breadcrumbs' => Breadcrumbs::render(),
            'order' => $order,
            'positions' => $this->applyFilters($order->positions())->with('status','order')->get(),
            'statuses' => OrderPositionStatus::orderBy('id')->get(),
        ];

        // если бы поиск

        if(request('s_article') && strlen(request('s_article')) > 2){

            if( request('s_type') == 'pl' ) {   // Ищем по прайслистам
                $data['s_pricelists_result'] = Price::ofArticle(request('s_article'))
                    ->ofActive()
                    ->with(['brand', 'product', 'pricelist'])
                    ->get();

            } elseif (request('s_type') == 'pr') {  // Ищем по товару
                $data['s_products_result'] = Product::ofArticle(request('s_article'))
                    ->with('brand')
                    ->withCount('prices')
                    ->get();
            }
        }

        return view('layouts.contractor.orders.positions.index', $data);
    }


    public function addToOrderFromPricelist(Request $request, Order $order, Price $price)
    {

        if( ! $request->quantity ){
            return back()->withNoticeError('Количество должно быть не менее 1');
        }

        $data = [
            'article' => $price->product ? $price->product->article : $price->article,
            'article_fixed' => $price->product ? $price->product->article_fixed : $price->article_fixed,
            'brand_name' => $price->product ? $price->product->brand->name : $price->brand_name,
            'brand_id' => $price->product ? $price->product->brand_id : $price->brand_id,
            'name_rus' => $price->product ? $price->product->name_rus : '',
            'name_eng' => $price->product ? $price->product->name_eng : $price->name,
            'product_id' => $price->product_id,
            'quantity' => $request->quantity,
            'markup' => $price->product ? $price->product->brand->markup : 0,
            'core' => $price->core,
            'price' => $price->price,
            'url' => $price->url,
            'comment' => '',

//            'status_id' => $price->product ? 2 : 1
            'status_id' => 1
        ];

        $position = $order->positions()->create($data);
        $position->updatePrices();

        return back()->withNoticeSuccess('Позиция добавлена в заказ');
    }

    public function addToOrderFromProducts(Request $request, Order $order, Product $product)
    {

        if( ! $request->quantity ){
            return back()->withNoticeError('Количество должно быть не менее 1');
        }

        $data = [
            'article' => $product->article,
            'article_fixed' => $product->article_fixed,
            'brand_name' => $product->brand->name,
            'brand_id' => $product->brand_id,
            'name_rus' => $product->name_rus,
            'name_eng' => $product->name_eng,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'markup' => $product->brand->markup ?? 0,
            'core' => 0,
            'price' => 0,
            'url' => $product->url,
            'comment' => '',

//            'status_id' => $price->product ? 2 : 1
            'status_id' => 1
        ];

        $position = $order->positions()->create($data);
        $position->updatePrices();

        return back()->withNoticeSuccess('Позиция добавлена в заказ');
    }

    public function addProduct(Order $order, OrderPosition $position)
    {
        if($position->isProductOk()){ return back()->withNoticeSuccess('Товар присутствует в базе'); }

        $data = [
            'page_title' => 'Добавление данных в справочники',
            'breadcrumbs' => Breadcrumbs::render(),
            'brands' => Brand::orderBy('name')->get(),
            'order' => $order,
            'position' => $position
        ];

        return view('layouts.contractor.orders.positions.add_product', $data);
    }

    /**
     * Сохранение нового бренда или синонима бренда в справочнике
     *
     * @param Request $request
     * @param OrderPosition $position
     */
    public function storeBrand(Request $request, OrderPosition $position)
    {
        (new BrandController())->createBrandOrSynonym($request);
        if($brand = Brand::getByName($request->name)){
            $position->update([
                'brand_name' => $brand->name,
                'brand_id' => $brand->id,
                'markup' => $brand->markup
            ]);
            return back()->withNoticeSuccess('Бренд определен');
        }

        return back()->withNoticeSuccess('Что-то пошло не так');
    }

    /**
     * Сохранение нового товара в справочнике
     *
     * @param Request $request
     * @param OrderPosition $position
     */
    public function storeProduct(Request $request, OrderPosition $position)
    {
        if($product = (new ProductController())->createProduct($request)){
            $data = [
                'product_id' => $product->id,
                'name_rus' => $product->name_rus,
                'name_eng' => $product->name_eng,
                'url' => $product->url,
                'comment' => $position->comment
            ];

            $prices = Price::findPrices($position->article, $position->brand_id);
            if($prices->count()){
                foreach ($prices as $key => $price) {
                    if($key == 0){
                        $data['price'] = $price->price;
                    } else {
                        $data['comment'] .= ' Цены:'. $price->pricelist->name . ':' . $price->price . '; ';
                    }
                }
            }

            $position->update($data);
            $position->refresh();
            $position->updatePrices();

            return redirect()->route('c.order.positions.index',$position->order_id)->withNoticeSuccess('Товар создан');
        }

        return back()->withNoticeSuccess('Что-то пошло не так');
    }

    /**
     * Перепроверка позиций на наличие бренда и товара в справочниках
     * Если указана позиция, то проверяем только ее, если же нет, то все несоответствующие
     *
     * @param OrderPosition|null $position
     */
    public function verify(Order $order, OrderPosition $position = null)
    {
        if($position){
            $positions = collect([$position]);
        } else {
            $positions = $order->positions()->whereNull('product_id')->get();
        }

        // Будем запоминать какие бренды мы уже искали и какой был результат
        // Структура такая [ 'имя бренда у позиции (key)' => [ 'brand_id' => '', 'brand_name' => '']]
        $brands_cache = [];

        foreach ($positions as $position){

            if( ! $position->isBrandOk() ){

                $key = $position->brand_name;

                // Если такой бренд еще не искали, то ищем
                if( ! Arr::has($brands_cache, $key) ) {
                    $brands_cache[$key] = [];
                    if( $brand = Brand::getByName($key) ){
                        $brands_cache[$key] = [
                            'brand_id'=>$brand->id,
                            'brand_name'=>$brand->name
                        ];
                    }
                }

                // если что-то было найдено, то обновляем данные в позиции заказа
                if (count($brands_cache[$key])){
                    $position->update($brands_cache[$key]);
                    $position->refresh();
                }

            }

            // если бренд есть, а товара нет, то пробуем поискать
            if( $position->isBrandOk() && ! $position->isProductOk() ){
                if($id = Product::getIdByArticleAndBrand($position->article, $position->brand_id)) {
                    $position->update(['product_id' => $id]);
                }
            }
        }

        return back()->withNoticeSuccess('Проверка завершена');
    }

    public function upload(Request $request, Order $order)
    {
        $this->authorize('upload', $order);

        $this->validate($request, [
            'userfile' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new OrderPositionsImport($order->id), $request->file('userfile'));

        return back()->withNoticeSuccess('Позиции добавлены в заказ');
    }

    public function updateField(Request $request, OrderPosition $position)
    {
            Validator::make($request->all(), [
                'inner_number' => [
                    'sometimes',
                    'filled'
                ],
            ])->validate();

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $position) ) {
            $position->setLogs($logs);
            $position->update($request->all());

            if($request->has('price') || $request->has('core') || $request->quantity){
                $position->refresh();
                $position->updatePrices();
            }
        }

        if(!$request->ajax()){
            return back()->withNoticeSuccess(__('messages.db.record_updated'));
        }
    }

    /**
     * Полный список позиций заказов
     */
    public function showAll()
    {
        // сохраняем в сессии запрос
        $filterName = 'c.all-orders-positions';

        $this->setFilter($filterName);

        $positions = OrderPosition::whereHas('order', function($q){
            $q->where('user_id', \Auth::id());
        });

        $data = [
            'page_title' => 'Позиции всех заказов',
            'breadcrumbs' => Breadcrumbs::render(),
            'positions' => $this->applyFilters($positions, 'updated_at', 'desc')
                ->with('order')
                ->paginate(25)
                ->withPath($this->getURLWithFilters($filterName)),

            //'statuses' => OrderPositionStatus::ofConfirmed()->withCount('positions')->orderBy('id')->get(),

            //'order_statuses' => OrderStatus::ofConfirmed()->orderBy('id')->get(),
        ];

        return view('layouts.contractor.orders.positions.all', $data);
    }

    /**
     * @param Order $order
     * @param OrderPosition $position
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Order $order, OrderPosition $position)
    {
        if ( ($order->id != $position->order_id) || !$order->isStatus('prep') ) abort(403);

        $position->delete();

        return back()->withNoticeSuccess(__('messages.db.record_deleted'));
    }


    public function export()
    {
//        $this->authorize('export_positions', Order::class);

//        $positions = OrderPosition::whereHas('order', function($q){
//            $q->where('user_id', \Auth::id());
//        });
//        $positions = $this->applyFilters($positions);
//        $positions = $positions->with('status')->orderBy('updated_at', 'desc')->get();
//
//        if(!$positions->count()){
//            return back()->withNoticeError('Нечего сохранять');
//        }
//
////        $filename_prefix = request('for_order') ? 'zakaz_' : '';
//        $filename_prefix = '';
//        $filename = $filename_prefix.'orders_positions_'.Carbon::now()->format('Y_m_d_H_i_s');
//        Excel::create( $filename, function($excel) use ($positions){
//            $excel->sheet( 'Позиции заказов', function($sheet) use ($positions){
//
//                $sheet->appendRow([
//                    'Производитель',
//                    'Артикул',
//                    'Деталь',
//                    'Количество',
//                    '№ заказа',
//                    'Статус',
//                ]);
//                foreach($positions as $position)
//                {
//                    $data = [
//                        $position->brand,
//                        $position->article,
//                        $position->name_eng,
//                        $position->quantity,
//                        $position->order->number,
//                        $position->status->name,
//                    ];
//                    $sheet->appendRow($data);
//                };
//            });
//
//        })->download('xlsx');
    }

    // Добавляет к запросу фильтры
    public function applyFilters($q, $sortField='id', $sortDir='ASC')
    {
        // Фильтр: Номер заказа
        if(request('number')){
            $q->whereHas('order', function($q){
                $q->where('number', 'like', '%'.request('number').'%');
            });
        }

        // Фильтр: Артикул
        if(request('article')){
            $q->where('article', 'like', '%'.request('article').'%');
        }

        // Фильтр: Производитель
        if(request('brand')){
            $q->where('brand', 'like', '%'.request('brand').'%');
        }

        // Фильтр: Статус
        if(request('status_id')){
            $q->where('status_id', request('status_id'));
            // если указано показывать только просроченные, то проверяем статус и добавляем фильтрацию
            if( request()->has('expired') ) {
                $status = OrderPositionStatus::find(request('status_id'));
                if ($status && $status->code == 'vendor_ordered') {
                    $q->where('vendor_ordered_at','<',Carbon::now()->subDays(7));
                }
            }
        }

        // Фильтр: Статус заказа
        if(request('order_status_id')){
            $q->whereHas('order', function($q) {
                $q->where('status_id', request('order_status_id'));
            });
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
