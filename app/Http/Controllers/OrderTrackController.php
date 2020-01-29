<?php

namespace App\Http\Controllers;

use App\DeliveryService;
use App\Order;
use App\OrderTrack;
use Breadcrumbs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class OrderTrackController extends Controller
{
    public $filterName = 'e.order-tracks';

    public function index(Order $order)
    {
        $this->setFilter();

        $data = [
            'page_title' => 'Треки заказа ' . $order->number,
            'breadcrumbs' => Breadcrumbs::render(),
            'order' => $order,
            'tracks' => $this->applyFilters($order->tracks())->with('delivery_service')->get(),
            'delivery_services' => DeliveryService::orderBy('name')->get()
        ];

        return view('layouts.employee.orders.tracks.index', $data);
    }

    public function all()
    {
        $this->setFilter('e.orders-tracks-all');

        $data = [
            'page_title' => 'Треки заказов',
            'breadcrumbs' => Breadcrumbs::render(),
            'tracks' => $this->applyFilters(OrderTrack::orderBy('number'))
                ->with(['order', 'delivery_service'])
                ->paginate(50)
                ->withPath($this->getURLWithFilters('e.order-tracks-all')),
        ];

        return view('layouts.employee.orders.tracks.all_tracks', $data);
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'number' => [
                'required',
                Rule::unique('order_tracks')
            ]
        ]);

        $order->tracks()->create($request->all());

        return back()->withNoticeSuccess(__('messages.db.record_created'));
    }

    public function eConfirm(OrderTrack $track)
    {
        if($track->e_received_at){
            $track->e_received_at = null;
        } else {
            $track->e_received_at = Carbon::now();
        }

        $track->save();

        return back()->withNoticeSuccess(__('messages.db.record_updated'));
    }

    public function destroy(Order $order, OrderTrack $track)
    {

        $track->delete();
        return back()->withNoticeSuccess(__('messages.db.record_deleted'));
    }

    public function updateField(Request $request, OrderTrack $track)
    {
            Validator::make($request->all(), [
                'number' => [
                    'sometimes',
                    'filled',
                    Rule::unique('order_tracks')
                ]
            ])->validate();

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $track) ) {
            $track->setLogs($logs);
            $track->update($request->all());
        }

        if(!$request->ajax()){
            return back()->withNoticeSuccess(__('messages.db.record_updated'));
        }
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
