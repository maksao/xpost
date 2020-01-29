<?php

namespace App\Http\Controllers\Contractor;

use App\DeliveryType;
use App\Http\Controllers\Controller;
use App\Order;
use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public $filterName = 'contractor.orders';

    public function index()
    {
        $this->setFilter();

        $data = [
            'page_title' => 'Заказы',
            'breadcrumbs' => Breadcrumbs::render(),
            'orders' => $this->applyFilters(\Auth::user()->orders())->with('invoice')->withCount('positions','tracks')->latest()->get(),
            'delivery_types' => DeliveryType::orderBy('pos')->orderBy('name')->get()
        ];

        return view('layouts.contractor.orders.index', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Order::class);

        $request->validate([
            'number' => [
                'required',
                Rule::unique('orders')->where(function($q){
                    $q->where('user_id', \Auth::id());
                }),
            ]
        ]);

        \Auth::user()->orders()->create($request->all());

        return redirect()->route('c.orders.index')->withNoticeSuccess('Заказ создан');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return redirect()->route('c.orders.index')->withNoticeSuccess(__('messages.db.record_deleted'));
    }

    // Подтверждение заказа
    public function accept(Order $order)
    {
        $this->authorize('accept', $order);

        $order->update(['status_id'=>2]);
        $order->positions()->update(['status_id' => 2]);

        $order->setLog('Заказ подтвержден');
        return back()->withNoticeSuccess(__('Заказ подтвержден'));
    }

    // Отмена подтверждения заказа
    public function reject(Order $order)
    {
        $this->authorize('reject', $order);

        $order->update(['status_id'=>1]);
        $order->positions()->update(['status_id' => 1]);

        $order->setLog('Отмена подтверждения заказа');
        return back()->withNoticeSuccess(__('Подтверждение отменено'));
    }

    public function clear(Order $order)
    {
        if( !$order->isStatus('prep') ){
            return back()->withNoticeError('Низззяя');
        }
        $order->positions()->delete();
        return back()->withNoticeSuccess(__('Заказ очищен'));
    }

    public function updateField(Request $request, Order $order)
    {
        $request->validate([
            'article' => [
                'sometimes',
                'filled'
            ],
        ]);

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $order) ) {
            $order->setLogs($logs);
            $order->update($request->all());
        }

        if(!$request->ajax()){
            return back()->withNoticeSuccess(__('messages.db.record_updated'));
        }
    }

    // Добавляет к запросу фильтры
    public function applyFilters($query)
    {
        // ID
        if(request('id')){
            return $query->where('id', request('id'));
        }
        // Фильтр: Номер заказа
        if(request('number')){
            $query->where('number', 'like', '%'.request('number').'%');
        }

        // Фильтр: Статус заказа
        if(request('order_status_id')){
            $query->where('status_id', request('order_status_id'));
        }

        return $query;
    }
}
