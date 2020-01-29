<?php

namespace App\Http\Controllers;

use App\DeliveryType;
use App\Helpers;
use App\Order;
use App\OrderStatus;
use App\User;
use Breadcrumbs;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $filterName = 'employee.orders';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->setFilter();

        $data = [
            'page_title' => 'Заказы',
            'breadcrumbs' => Breadcrumbs::render(),
            'orders' => $this->applyFilters(Order::select())->where('status_id', '<>', 1)->with('invoice')->withCount('user','positions','tracks')->latest()->get(),
            'delivery_types' => DeliveryType::orderBy('pos')->orderBy('name')->get()
        ];

        return view('layouts.employee.orders.index', $data);
    }

    public function updateField(Request $request, Order $order)
    {
        $request->validate([
            'article' => [
                'sometimes',
                'filled'
            ],
            'weight' => 'sometimes|regex:/^\d+(\.\d{1,2})?$/'
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
