<?php

namespace App\Http\Controllers\Spr;

use App\DeliveryType;
use App\Http\Controllers\Controller;
use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class DeliveryTypeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\InvalidBreadcrumbException
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\UnnamedRouteException
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\ViewNotSetException
     */
    public function index()
    {
        $data = [
            'page_title' => 'Типы доставки',
            'breadcrumbs' => Breadcrumbs::render(),
            'types' => DeliveryType::orderBy('pos')->orderBy('name')->get(),
        ];

        return view('spr.delivery_types.index', $data);
    }

    /**
     * @param Request $request
     * @return
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('delivery_types')],
        ]);
        $request->merge(['pos'=>DeliveryType::max('pos')+1]);
        DeliveryType::create($request->all());
        return redirect()->route('delivery-types.index')->withNoticeSuccess(__('messages.db.record_created'));
    }

    /**
     * @param DeliveryType $deliveryType
     * @return
     * @throws \Exception
     */
    public function destroy(DeliveryType $deliveryType)
    {
        $deliveryType->deleteWithUpdatePosition();
        return redirect()->route('delivery-types.index')->withNoticeSuccess(__('messages.db.record_deleted'));
    }

    public function updateField(Request $request, DeliveryType $type)
    {
        Validator::make($request->all(), [
            'pos' => [
                'sometimes',
                'filled',
            ],
            'name' => [
                'sometimes',
                Rule::unique('delivery_types')->ignore($type->id)
            ],
        ])->validate();

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $type) ) {
            // если меняли позицию, то обновляем ее и в таблице разрешений
            if($request->pos){
                $type->updatePosition($request->pos);
            } else {
//                $type->setLogs($logs);
                $type->update($request->all());
            }
        }

        if(!$request->ajax()){
            return back()->withNoticeSuccess(__('messages.db.record_updated'));
        }
    }

}
