<?php

Auth::routes([
    'register'=>false,
    'verify'=>false
]);



Route::middleware('auth')->group(function(){

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/home', function () {
        return redirect()->route('home');
    });
    Route::get('users/return-to-account', 'UsersController@returnToAccount')->name('users.return-to-account');
    Route::middleware('employee')->get('logs/{model}/{id}', 'LogController@show')->name('logs.show');

    Route::get('test', function (){ return view('tests.m_pop_test'); });

    // СОТРУДНИК

    Route::middleware('employee')
        ->prefix('e')
        ->name('e.')
        ->group(function(){

            //
            // ЗАКАЗЫ
            //

            /*
            |--------------------------------------------------------------------------
            |
            | Заказы
            |
            |--------------------------------------------------------------------------
            */
            Route::resource('orders', 'OrderController');
            // Быстрое редактирование
            Route::post('orders/{order}/field','OrderController@updateField' )->name('orders.field.update');

            /*
            |--------------------------------------------------------------------------
            | Позиции заказа
            |--------------------------------------------------------------------------
            */
            Route::resource('order.positions', 'OrderPositionController');
            // Выгрузка для заказа
            Route::get('order-positions/export-for-order', 'OrderPositionController@exportForOrder')->name('order-positions.export-for-order');
            // Разделение позиции
            Route::post('order-positions/{position}/split', 'OrderPositionController@split')->name('order-positions.split');
            // Быстрое редактирование
            Route::post('order-positions/{position}/field','OrderPositionController@updateField' )->name('order-positions.field.update');
            /*
            |--------------------------------------------------------------------------
            | Позиции всех заказов
            |--------------------------------------------------------------------------
            */
            Route::get('all-orders-positions', 'OrderPositionController@showAll')->name('all-orders-positions.index');

            // Треки
            Route::resource('order.tracks', 'OrderTrackController');
            // Быстрое редактирование
            Route::post('order-tracks/{track}/field','OrderTrackController@updateField' )->name('order-tracks.field.update');
            Route::get('order-tracks/{track}/e-confirm', 'OrderTrackController@eConfirm')->name('order-tracks.e-confirm');

            // Все треки
            Route::get('orders-tracks-all', 'OrderTrackController@all')->name('orders-tracks-all');

            /*
            |--------------------------------------------------------------------------
            |
            | Инвойсы
            |
            |--------------------------------------------------------------------------
            */
            Route::resource('invoices', 'InvoiceController');

            // УПРАВЛЕНИЕ

            /*
            |--------------------------------------------------------------------------
            |
            | Пользователи
            |
            |--------------------------------------------------------------------------
            */
            Route::resource('users', 'UsersController');
            Route::put('users/{user}/account', 'UsersController@updateAccount')->name('users.account');
            Route::get('users/{user}/login-as', 'UsersController@loginAs')->name('users.login-as');


    });


    // КОНТРАГЕНТ

    Route::middleware('contractor')
        ->namespace('Contractor')
        ->prefix('c')
        ->name('c.')
        ->group(function(){

           /*
           |--------------------------------------------------------------------------
           |
           | Заказы
           |
           |--------------------------------------------------------------------------
           */

            Route::resource('orders', 'OrderController');
            // Подтверждение заказа
            Route::post('orders/{order}/accept','OrderController@accept' )->name('orders.accept');
            // Отмена подтверждения заказа
            Route::post('orders/{order}/reject','OrderController@reject' )->name('orders.reject');
            // Очистка заказа
            Route::post('orders/{order}/clear','OrderController@clear' )->name('orders.clear');
            // Быстрое редактирование
            Route::post('orders/{order}/field','OrderController@updateField' )->name('orders.field.update');

            /*
            |--------------------------------------------------------------------------
            | Позиции заказа
            |--------------------------------------------------------------------------
            */
            Route::resource('order.positions', 'OrderPositionController');

            Route::post('order/{order}/positions/upload', 'OrderPositionController@upload')->name('order.positions.upload');

            // Добавление позиции в справочники
            Route::get('order/{order}/positions/{position}/add-product', 'OrderPositionController@addProduct')->name('order.positions.add-product');
            Route::post('order-positions/{position}/store-brand', 'OrderPositionController@storeBrand')->name('order-positions.store-brand');
            Route::post('order-positions/{position}/store-product', 'OrderPositionController@storeProduct')->name('order-positions.store-product');

            // Добавление позиции в заказ из справочника товара через прайслист (price)-позиция прайслиста
            Route::post('order/{order}/products/{price}/add-from-pricelist', 'OrderPositionController@addToOrderFromPricelist')->name('order.products.add-from-pricelist');
            // Добавление позиции в заказ из справочника товара
            Route::post('order/{order}/products/{product}/add-from-products', 'OrderPositionController@addToOrderFromProducts')->name('order.products.add-from-products');

            // Перепроверка позиций
            Route::any('orders/{order}/verify-positions/{position?}','OrderPositionController@verify' )->name('orders.verify-positions');

            // Быстрое редактирование
            Route::post('order-positions/{position}/field','OrderPositionController@updateField' )->name('order-positions.field.update');

            /*
            |--------------------------------------------------------------------------
            | Позиции всех заказов
            |--------------------------------------------------------------------------
            */
            Route::get('all-orders-positions', 'OrderPositionController@showAll')->name('all-orders-positions.index');

            /*
            |--------------------------------------------------------------------------
            | Треки
            |--------------------------------------------------------------------------
            */
            Route::resource('order.tracks', 'OrderTrackController');
            Route::get('order-tracks/{track}/c-confirm', 'OrderTrackController@cConfirm')->name('order-tracks.c-confirm');

        }
    );

    /*
    |--------------------------------------------------------------------------
    |
    | Цены
    |
    |--------------------------------------------------------------------------
    */
    Route::resource('pricelists', 'PricelistController');
    // Загрузка файла
    Route::post('pricelists/{pricelist}/upload','PricelistController@upload' )->name('pricelists.upload');
    // Оцистка прайса
    Route::get('pricelists/{pricelist}/clear','PricelistController@clear' )->name('pricelists.clear');
    // Перепроверка брендов по справочнику
    Route::get('pricelists/{pricelist}/brands','PricelistController@brands' )->name('pricelists.brands');
    // Перепроверка товара по справочнику
    Route::get('pricelists/{pricelist}/products','PricelistController@products' )->name('pricelists.products');
    // Сброс задачи
    Route::get('pricelists/{pricelist}/cancel-job','PricelistController@cancelJob' )->name('pricelists.cancel-job');
    // Быстрое редактирование
    Route::post('pricelists/{pricelist}/field','PricelistController@updateField' )->name('pricelists.field.update');
    // Быстрое редактирование позиций
    Route::post('pricelists/prices/{price}/field','PricelistController@updatePriceField' )->name('pricelist.prices.field.update');
    // Переключение флагов у цен
    Route::get('pricelist/prices/{price}/toggle-{param}','PricelistController@togglePriceFlag' )->name('pricelist.prices.toggle-flag');
    // Добавление позиции прайса в справочник товара
    Route::post('pricelist/prices/{price}/add-to-products','PricelistController@add' )->name('pricelist.prices.add-to-products');


    //
    // СПРАВОЧНИКИ
    //

    Route::group(['namespace' => 'Spr'], function () {

        /*
        |--------------------------------------------------------------------------
        |
        | Товар
        |
        |--------------------------------------------------------------------------
        */
        // Товар
        Route::resource('products', 'ProductController');
        // Загрузка из файла
        Route::post('products/upload','ProductController@upload' )->name('products.upload');
        // Быстрое редактирование
        Route::post('products/{product}/field','ProductController@updateField' )->name('products.field.update');

        /*
        |--------------------------------------------------------------------------
        |
        | Бренды
        |
        |--------------------------------------------------------------------------
        */
        // Бренды
        Route::resource('brands', 'BrandController');
        // Быстрое редактирование
        Route::post('brands/{brand}/field','BrandController@updateField' )->name('brands.field.update');
        // Синонимы бренда
        Route::resource('brands.synonyms', 'BrandSynonymsController')->only(['index','store','destroy']);
        // Преобразование бренда в синоним другого бренда
        Route::post('brands/{brand}/convert-to-synonym', 'BrandController@convertToSinonym')->name('brands.convert-to-synonym');
        // Создание бренда либо синонима
        Route::post('brands/create-brand-or-synonym','BrandController@createBrandOrSynonym' )->name('brands.create-brand-or-synonym');

        /*
        |--------------------------------------------------------------------------
        |
        | Типы доставки
        |
        |--------------------------------------------------------------------------
        */
        // Типы доставки
        Route::resource('delivery-types', 'DeliveryTypeController')->only(['index','store','destroy']);
        // Быстрое редактирование
        Route::post('delivery-type/{type}/field','DeliveryTypeController@updateField' )->name('delivery-types.field.update');

        /*
        |--------------------------------------------------------------------------
        |
        | Службы доставки по США
        |
        |--------------------------------------------------------------------------
        */
        // Типы доставки
        Route::resource('delivery-services', 'DeliveryServiceController');
        // Быстрое редактирование
        Route::post('delivery-services/{service}/field','DeliveryServiceController@updateField' )->name('delivery-services.field.update');

    });
});
