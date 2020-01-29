<?php

namespace App\Http\Controllers;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use App;
use Str;

class LogController extends Controller
{
    public function show($model, $id)
    {
        $class = 'App\\' . Str::studly(str_replace('.', '\ ', $model));

        $model = $class::find($id);

        $page_title = 'История изменений';
        if(isset($model->name)){
            $page_title .= ' для: '.$model->name;
        }elseif (method_exists($model, 'getName')){
            $page_title .= ' для: '.$model->getName();
        }

        $data = [
            'page_title' => $page_title,
            'breadcrumbs' => Breadcrumbs::render(),
            'model' => $model,
            'logs' => $model->logs()->with('user:id,name')->orderBy('created_at', 'desc')->get()
        ];

        return view('logs', $data);
    }
}
