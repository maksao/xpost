<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Country;
use App\Exports\OrderPositionsForOrderExport;
use App\ExportType;
use App\Helpers;
use App\Mail\OrderPositionContractorRemoved;
use App\Mail\OrderPositionVendorRemoved;
use App\Operation;
use App\Order;
use App\OrderPosition;
use App\OrderPositionStatus;
use App\OrderStatus;
use App\User;
use Breadcrumbs;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Mail;

class OrderPositionController extends Controller
{
    public $filterName = 'e.order-positions';

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Order $order)
    {
        // сохраняем в сессии запрос
        $this->setFilter();

        $data = [
            'page_title' => 'Заказ ' . $order->number,
            'breadcrumbs' => Breadcrumbs::render(),
            'order' => $order->load('status', 'user', 'delivery_type'),
            'positions' => $this->applyFilters($order->positions(), 'article')->with('status')->get(),
            'statuses' => OrderPositionStatus::orderBy('id')->get(),
        ];

        return view('layouts.employee.orders.positions.index', $data);
    }


    /**
     * Полный список позиций заказов
     *
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showAll()
    {
        // сохраняем в сессии запрос
        $filterName = 'e.all-orders-positions';

        $this->setFilter($filterName);

        $data = [
            'page_title' => 'Позиции всех заказов',
            'breadcrumbs' => Breadcrumbs::render(),
            'positions' => $this->applyFilters(OrderPosition::where('status_id', '<>', 1), 'updated_at', 'desc')
                ->with('order')
                ->paginate(25)
                ->withPath($this->getURLWithFilters($filterName)),

//            'contractors' => User::whereHas('roles', function($q){
//                $q->where('code', 'contractor');
//            })
//                ->has('orders')
//                ->with('contractor_data')
//                ->get(),

//            'statuses' => OrderPositionStatus::ofConfirmed()->withCount('positions')->orderBy('id')->get(),
//            'order_statuses' => OrderStatus::ofConfirmed()->orderBy('id')->get(),
        ];

        return view('layouts.employee.orders.positions.all', $data);
    }

    public function exportForOrder()
    {
        request()->merge(['status_id' => 2]);

        $positions = $this->applyFilters(OrderPosition::select(), 'article');
        if(request('order_id')){
            $positions->where('order_id', request('order_id'));
        }
        $positions = $positions->with('order.user')->orderBy('updated_at', 'desc')->get();

        // Если список позиций пустой, не выгружаем ничего

        if(!$positions->count()){
            return back()->withNoticeError('Нечего сохранять');
        }

        // Выгрузка в файл

        $prefix = request('order_id') ? $positions->first()->order->number : 'all';
        $filename = $prefix . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        (new OrderPositionsForOrderExport($positions))
            ->store(ExportType::find(1)->path. '/' . $filename, 'exports');

        return \Storage::disk('exports')->download(ExportType::find(1)->path. '/' . $filename);
    }

    public function split(Request $request, OrderPosition $position)
    {
        if( !$request->qtty || $request->qtty >= $position->quantity || $position->quantity < 2){
            return back()->withNoticeError('Переданы ошибочные данные');
        }
        // создаем новую позицию? выставляем указанное количество и пересчитываем цену
        $new_position = $position->replicate();
        $new_position->quantity = $request->qtty;
        $new_position->save();
        $new_position->updatePrices();

        Helpers::setHL($new_position);

        // выставляем оставшееся количество у старой позиции и пересчитываем цену
        $position->update(['quantity' => $position->quantity - $request->qtty]);
        $position->updatePrices();

        return back()->withNoticeSuccess('Позиция разделена');
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

        // Фильтр: Страна
        if(request('country_id')){
            $q->where('country_id', request('country_id'));
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

        // Фильтр: Контрагент
        if(request('user_id')){
            $q->whereHas('order', function($q){
                $q->where('user_id', request('user_id'));
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

    public function updateField(Request $request, OrderPosition $position)
    {
        $request->validate([
            'article' => [
                'sometimes',
                'filled'
            ],
            'brand' => [
                'sometimes',
                'filled'
            ],
            'name_rus' => [
                'sometimes',
                'filled'
            ],
            'name_eng' => [
                'sometimes',
                'filled'
            ],
        ]);


        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $position) ) {
            $position->setLogs($logs);
            $position->update($request->all());

            if($request->has('price') || $request->has('core')){
                $position->refresh();
                $position->updatePrices();
            }
        }

        if(!$request->ajax()){
            return back()->withNoticeSuccess(__('messages.db.record_updated'));
        }
    }



}
