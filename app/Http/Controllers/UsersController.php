<?php

namespace App\Http\Controllers;

use App\User;
use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public $filterName = User::OBJ_CODE;

    public function index()
    {
        $this->authorize('view', User::class);

        $this->setFilter();

        $data = [
            'page_title' => 'Пользователи',
            'breadcrumbs' => Breadcrumbs::render(),
            'users' => $this->applyFilters(User::select(), 'name')->get()
        ];
        return view('users.index', $data);
    }

    public function create()
    {
        $this->authorize('view', User::class);
        $data = [
            'page_title' => 'Новый пользователь',
            'breadcrumbs' => Breadcrumbs::render(),
        ];
        return view('users.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => ['required', Rule::in(['C','E'])],
            'email' => [
                'required',
                'email',
                Rule::unique('users'),
            ],
            'password' => 'required|confirmed|min:6',
        ]);

        $request->merge([
            'password' => \Hash::make($request->password),
        ]);

        User::create($request->all());

        return redirect()->route('e.users.index')->withNoticeSuccess(__('messages.db.record_created'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $data = [
            'page_title' => 'Профиль пользователя: ' . $user->name,
            'breadcrumbs' => Breadcrumbs::render(),
            'user' => $user
        ];
        return view('users.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'name' => 'required',
            'type' => [
                'required',
                Rule::in(['C','E'])
            ],
        ]);
        $request->merge([
            'is_admin' => $request->has('is_admin') ? 1 : 0
        ]);
        $user->update($request->all());

        return back()->withNoticeSuccess(__('messages.db.record_updated'));
    }

    public function updateAccount(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'email' => [
                'required',
                'max:250',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|confirmed|min:6',
        ]);

        if($user->email != $request->email){
            $user->email = $request->email;
            //$user->setLog('Эл.адрес изменен на '.$request->email);
        }

        if($request->has('password')) {
            $user->password = \Hash::make($request->password);
            //$user->setLog('Обновлен пароль');
        }

        $user->save();

        return back()->withNoticeSuccess(__('messages.db.record_updated'));
    }

    public function loginAs(User $user)
    {
        $this->authorize('login_as', $user);

        // Запоминаем id того кто логинится
        session(['logged_from'=>\Auth::id()]);

        \Auth::logout();
        \Auth::login($user);
        if (\Auth::check()) return redirect('/');

        return back()->withNoticeErrors('Залогиниться не удалось');
    }

    public function returnToAccount()
    {
        $user = User::findOrFail(session('logged_from'));
        \Auth::logout();
        \Auth::login($user);
        session()->forget('logged_from');

        if (\Auth::check()) return redirect()->route('home')->withNoticeSuccess('С возвращением, '.$user->name);
        return back()->withNoticeErrors('Залогиниться не удалось');
    }

    // Добавляет к запросу фильтры
    public function applyFilters($q, $sortField='id', $sortDir='ASC')
    {
        // Фильтр: Имя
        if(request('name')){
            $q->where('name', 'like', '%'.request('name').'%');
        }

        // Фильтр: Email
        if(request('email')){
            $q->where('email', 'like', '%'.request('email').'%');
        }

        // Фильтр: Регион
        if(request('region')){
            $q->where('company_region_id', request('region'));
        }

        // Фильтр: Тип
        if(request('type')){
            $q->where('type', request('type'));
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
