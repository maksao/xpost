<?php

namespace App\Http\Controllers\Spr;

use App\DeliveryService;
use App\Http\Controllers\Controller;
use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class DeliveryServiceController extends Controller
{

    public function index()
    {
        $data = [
            'page_title' => 'Службы доставки по США',
            'breadcrumbs' => Breadcrumbs::render(),
            'items' => DeliveryService::orderBy('name')->get()
        ];

        return view('spr.delivery_services.index', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('delivery_services')],
        ]);
        DeliveryService::create($request->all());
        return redirect()->route('delivery-services.index')->withNoticeSuccess(__('messages.db.record_created'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeliveryService  $deliveryService
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryService $deliveryService)
    {
        $deliveryService->delete();
        return redirect()->route('delivery-services.index')->withNoticeSuccess(__('messages.db.record_deleted'));
    }

    public function updateField(Request $request, DeliveryService $service)
    {
        Validator::make($request->all(), [
            'name' => [
                'sometimes',
                Rule::unique('delivery_services')->ignore($service->id)
            ],
        ])->validate();

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $service) ) {
                $service->update($request->all());
        }

        if(!$request->ajax()){
            return back()->withNoticeSuccess(__('messages.db.record_updated'));
        }
    }
}
