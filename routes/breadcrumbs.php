<?php

// Главная
Breadcrumbs::for('home', function ($trail) { $trail->push('Главная', route('home')); });
// Логи
Breadcrumbs::for('logs.show', function ($trail) {
    $trail->parent('home');
    $trail->push('Вернуться назад', \URL::previous()); $trail->push('История изменений');
});

// Просмотр заказа
//Breadcrumbs::for('order.positions.index', function ($trail, $order) {
//    $trail->parent('orders.index');
//    $trail->push('Заказ '.$order->number, route('order.positions.index', $order->id));
//});


//**********************************************
//
// СОТРУДНИКИ
//
//**********************************************

// ЗАКАЗЫ И ЦЕНЫ

// Заказы
Breadcrumbs::for('e.orders.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Заказы', route('e.orders.index'));
});

// Просмотр заказа
Breadcrumbs::for('e.order.positions.index', function ($trail, $order) {
    $trail->parent('e.orders.index');
    $trail->push('Заказ '.$order->number, route('e.order.positions.index', $order->id));
});

// Позиции всех заказов
Breadcrumbs::for('e.all-orders-positions.index', function ($trail) {
    $trail->parent('e.orders.index');
    $trail->push('Позиции всех заказов', App\Helpers::getFilters('e.all-orders-positions', route('e.all-orders-positions.index')));
});

// Треки всех заказов
Breadcrumbs::for('e.orders-tracks-all', function ($trail) {
    $trail->parent('home');
    $trail->push('Все треки', App\Helpers::getFilters('e.orders-tracks-all', route('e.orders-tracks-all')));
});

// Треки заказа
Breadcrumbs::for('e.order.tracks.index', function ($trail, $order) {
    $trail->parent('e.orders.index');
    $trail->push('Треки заказа '.$order->number, route('e.order.tracks.index', $order->id));
});

// Инвойсы
Breadcrumbs::for('e.invoices.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Инвойсы', App\Helpers::getFilters('e.invoices', route('e.invoices.index')));
});

// Прайслисты
Breadcrumbs::for('pricelists.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Прайслисты', route('pricelists.index'));
});

// Просмотр цен
Breadcrumbs::for('pricelists.show', function ($trail, $pricelist) {
    $trail->parent('pricelists.index');
    $trail->push($pricelist->name, App\Helpers::getFilters('pricelist_prices', route('pricelists.index')));
});


// СПРАВОЧНИКИ
Breadcrumbs::for('spr', function ($trail) {
    $trail->parent('home');
    $trail->push('Справочники');
});

// Товар
Breadcrumbs::for('products.index', function ($trail) {
    $trail->parent('spr');
    $trail->push('Справочники');
    $trail->push('Товар', App\Helpers::getFilters(\App\Product::OBJECT_CODE, route('products.index')));
});

// Бренды
Breadcrumbs::for('brands.index', function ($trail) {
    $trail->parent('spr');
    $trail->push('Бренды', App\Helpers::getFilters(\App\Brand::OBJECT_CODE, route('brands.index')));
});
Breadcrumbs::for('brands.synonyms.index', function ($trail) {
    $trail->parent('brands.index');
    $trail->push('Синонимы');
});

// Типы доставки
Breadcrumbs::for('delivery-types.index', function ($trail) {
    $trail->parent('spr');
    $trail->push('Типы доставки', App\Helpers::getFilters(\App\DeliveryType::OBJECT_CODE, route('delivery-types.index')));
});

// Службы доставки по СЩА
Breadcrumbs::for('delivery-services.index', function ($trail) {
    $trail->parent('spr');
    $trail->push('Службы доставки по США', App\Helpers::getFilters(\App\DeliveryService::OBJECT_CODE, route('delivery-services.index')));
});


// УПРАВЛЕНИЕ

// Пользователи
Breadcrumbs::for('e.users.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Пользователи', App\Helpers::getFilters(\App\User::OBJ_CODE, route('e.users.index')));
});
Breadcrumbs::for('e.users.create', function ($trail) {
    $trail->parent('e.users.index');
    $trail->push('Новый пользователь');
});
Breadcrumbs::for('e.users.edit', function ($trail) {
    $trail->parent('e.users.index');
    $trail->push('Профиль пользователя');
});


//**********************************************
//
// КОНТРАГЕНТЫ
//
//**********************************************

// ЗАКАЗЫ

// Заказы
Breadcrumbs::for('c.orders.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Заказы', route('c.orders.index'));
});

// Просмотр заказа
Breadcrumbs::for('c.order.positions.index', function ($trail, $order) {
    $trail->parent('c.orders.index');
    $trail->push('Заказ '.$order->number, route('c.order.positions.index', $order->id));
});

// Добавление позиции в справочники
Breadcrumbs::for('c.order.positions.add-product', function ($trail, $order, $position) {
    $trail->parent('c.order.positions.index', $order);
    $trail->push('Добавление данных в справочники', route('c.order.positions.add-product', [$order->id, $position->id]));
});

// Позиции всех заказов
Breadcrumbs::for('c.all-orders-positions.index', function ($trail) {
    $trail->parent('c.orders.index');
    $trail->push('Позиции всех заказов', App\Helpers::getFilters('c.all-orders-positions', route('c.all-orders-positions.index')));
});

// Треки заказа
Breadcrumbs::for('c.order.tracks.index', function ($trail, $order) {
    $trail->parent('c.orders.index');
    $trail->push('Треки заказа '.$order->number, route('c.order.tracks.index', $order->id));
});
