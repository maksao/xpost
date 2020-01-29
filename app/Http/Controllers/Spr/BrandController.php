<?php

namespace App\Http\Controllers\Spr;

use App\Brand;
use App\BrandSynonym;
use App\DiscountGroup;
use App\Http\Controllers\Traits\SetDefaultTrait;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;

class BrandController extends Controller
{
    use SetDefaultTrait;

    public $filterName = Brand::OBJECT_CODE;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // сохраняем в сессии запрос
        $this->setFilter();

        $data = [
            'page_title' => 'Бренды',
            'breadcrumbs' => Breadcrumbs::render(),
            'brands' => $this->applyFilters(Brand::select(), 'name')->withCount('synonyms')
                ->paginate(25)
                ->withPath($this->getURLWithFilters()),
        ];
        return view('spr.brands.index', $data);
    }

//    public function show(Brand $brand)
//    {
//        return view('spr.brands.show')->withBrand($brand->load('discount_groups'));
//    }
//
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:brands',
        ]);
        $brand = Brand::create($request->all());
        // И сразу создаем синоним
        $brand->synonyms()->create(['name'=>mb_strtolower($brand->name),]);
        // Присоединяем производителя к группе "Розница"
        // непонятно зачем, поэтому пока отключено
//        $brand->discount_groups()->attach(1);

        return back()->withNoticeSuccess(__('messages.db.record_created'));
    }

    /*
     * Если указан parent_id, то создаем синоним, а если нет, о бренд
     */
    public function createBrandOrSynonym(Request $request)
    {
        if($request->parent_id){
            return (new BrandSynonymsController())->store($request, Brand::findOrFail($request->parent_id));
        } else {
            return $this->store($request);
        }
    }

    public function updateField(Request $request, Brand $brand)
    {
        Validator::make($request->all(), [
            'name' => [
                'sometimes',
                Rule::unique('brands')->ignore($brand->id)
            ],
            'markup' => 'sometimes|numeric',
        ])->validate();

        // обновляем только если были изменения
        if( $logs = $this->checkFieldsUpdateChanges($request->all(), $brand) ) {
            $brand->setLogs($logs);
            $brand->update($request->all());
        }
    }

    /*
     * Редактирование скидок на производителей
     */
    public function editDiscountGroups(Brand $brand)
    {
        $data = [
            'page_title' => 'Скидки для брендов: "'.$brand->name.'"',
            'breadcrumbs' => Breadcrumbs::render(),
            'brand' => $brand,
            'discount_groups' => DiscountGroup::with(['brands' => function($q) use ($brand){
                $q->where('id', $brand->id);
            }])->orderBy('name')->get(),
        ];
        return view('spr.brands.discount_groups', $data);
    }

    /*
     * Обновление скидок на производителей
     */
    public function updateDiscountGroups(Request $request, Brand $brand)
    {
        $brand->discount_groups()->sync($request->brands);
        return back()->withNoticeSuccess('Изменения сохранены');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return back()->withNoticeSuccess(__('messages.db.record_deleted'));
    }

    public function convertToSinonym(Request $request, Brand $brand)
    {
        $request->validate( [
            'parent_id' => [
                'required',
                Rule::exists('brands','id'),
                Rule::notIn([$brand->id]),
            ]
        ],[
            'not_in' => 'Родительский бренд указан ошибочно',
        ]);

        $parent_brand = Brand::findOrFail($request['parent_id']);

        // переводим синонимы в новый бренд
        $brand->synonyms()->update(['brand_id'=>$parent_brand->id]);
        // переводим товар в новый бренд
        $brand->products()->update(['brand_id'=>$parent_brand->id]);

        // пишем лог
        $parent_brand->setLog('Бренд "'.$brand->name.'" преобразован в синоним бренда "'.$parent_brand->name.'"');

        // удаляем старый бренд
        $brand->delete();

        return back()->withNoticeSuccess('Бренд преобразован в синоним');
    }

    // Добавляет к запросу фильтры
    public function applyFilters($q, $sortField='id', $sortDir='ASC')
    {

        // Фильтр: id - если указан, то ничего больше не фильтруем
        if(request('id')){
            return $q->where('id', request('id'));
        }

        // Фильтр: Название
        if(request('name')){
            $q->where('name', 'like', '%' . request()->name . '%')
                ->orWhereHas('synonyms', function ($q) {
                    $q->where('name', 'like', '%' . request('name') . '%');
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
