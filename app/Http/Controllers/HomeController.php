<?php

namespace App\Http\Controllers;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Пользователь - админ или сотрудник
        if(\Auth::user()->isEmployee()){
            return $this->employeeIndex();
        }
        // Пользователь - контрагент
        return $this->contractorIndex();
    }

    protected function employeeIndex()
    {
//        $base_uri = 'http://maks:123maks123@192.168.80.254';
//        $client = new \GuzzleHttp\Client(['base_uri' => $base_uri]);
//
//        $query =  [
//            'headers' => [
//                'User-Agent' => 'Mozilla/5.0 (Android 4.4; Mobile; rv:41.0) Gecko/41.0 Firefox/41.0',
//            ],
//            'json' => [["Производитель"=>"TOYOTA", "НомерДетали"=>"8521452110"], ["Производитель"=>"TOYOTA", "НомерДетали"=>"8521452111"]]
//        ];
//
//        $res = $client->request('POST', '/prices/hs/Parts', $query);
//
//        dd($res->getBody()->getContents());
//
        $data = [
            'page_title' => 'Главная страница',
            'breadcrumbs' => Breadcrumbs::render(),
        ];

        return view('layouts.employee.index', $data);
    }

    protected function contractorIndex()
    {

        $contractor = \Auth::user();

//        $operations = $contractor->operations()->when((request('from') && request('to')), function($q){
//            return $q->whereBetween('date', [request('from'), request('to')]);
//        }, function($q){
//            return $q->whereBetween('date', [Carbon::now()->subDays(30)->format('Y-m-d'), Carbon::now()->format('Y-m-d')]);
//        })
//            ->when(request('op_type'), function($q){
//                return $q->where('operation_type_id', request('op_type'));
//            })
//            ->with('operation_type')->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
//
//        $data = [
//            'contractor' => $contractor,
//            'operations' => $operations,
//            'balance_total' => $contractor->balances()->sum('total'),
//        ];

        $data = [
            'page_title' => 'Главная страница',
            'breadcrumbs' => Breadcrumbs::render(),
        ];

        return view('layouts.contractor.index', $data);
    }


}
