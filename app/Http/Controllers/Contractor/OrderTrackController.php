<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderTrack;
use Breadcrumbs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderTrackController extends Controller
{
    public $filterName = 'c.order-tracks';

    public function index(Order $order)
    {
        $this->authorize('view', $order);

        $this->setFilter();

        $data = [
            'page_title' => 'Треки заказа ' . $order->number,
            'breadcrumbs' => Breadcrumbs::render(),
            'order' => $order,
            'tracks' => $this->applyFilters($order->tracks())->get(),
        ];

        return view('layouts.contractor.orders.tracks.index', $data);
    }

    public function cConfirm(OrderTrack $track)
    {
        if($track->c_received_at){
            $track->c_received_at = null;
        } else {
            $track->c_received_at = Carbon::now();
        }

        $track->save();

        return back()->withNoticeSuccess(__('messages.db.record_updated'));
    }

    // Добавляет к запросу фильтры
    public function applyFilters($q, $sortField='id', $sortDir='ASC')
    {
        // Фильтр: Номер
        if(request('number')){
            $q->where('number', 'like', '%'.request('number').'%');
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
