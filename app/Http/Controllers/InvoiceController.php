<?php

namespace App\Http\Controllers;

use App\Invoice;
use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public $filterName = 'invoices';

    public function index()
    {
        $this->setFilter();

        $data = [
            'page_title' => 'Инвойсы',
            'breadcrumbs' => Breadcrumbs::render(),
            'invoices' => $this->applyFilters(Invoice::select())->withCount('orders')->latest()->get(),
        ];

        return view('layouts.employee.invoices.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => [
                'required',
                Rule::unique('invoices')
            ]
        ]);

        $invoice = Invoice::create($request->all());

        $msg = 'Инвойс создан';
        $invoice->setLog($msg);

        return back()->withNoticeSuccess($msg);
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
//        if(request('order_status_id')){
//            $query->where('status_id', request('order_status_id'));
//        }

        return $query;
    }
}
