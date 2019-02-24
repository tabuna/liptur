<?php

$this->domain(config('platform.domain'))->group(function () {

    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix('/shop'),
    ],
    function (\Illuminate\Routing\Router $router, $path = 'dashboard.liptur.shop.') {
        $router->screen('order/{order}/edit', 'Orders\OrderEdit', $path.'order.edit');
        $router->screen('order', 'Orders\OrderList', $path.'order.list');
    });

    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix('/shop'),
    ],
    function (\Illuminate\Routing\Router $router, $path = 'dashboard.liptur.shop.') {
        $router->screen('product-arrival/{productArrival}/edit', 'ProductArrivals\ProductArrivalEdit', $path.'product-arrival.edit');
        $router->screen('product-arrival', 'ProductArrivals\ProductArrivalList', $path.'product-arrival.list');
    });

    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix('/shop'),

    ],
    function (\Illuminate\Routing\Router $router, $path = 'dashboard.liptur.shop.') {
        $router->screen('shortvar/{shortvar}/edit', 'Shortvars\ShortvarEdit', $path.'shortvar.edit');
        $router->screen('shortvar/create', 'Shortvars\ShortvarEdit', $path.'shortvar.create');
        $router->screen('shortvar', 'Shortvars\ShortvarsList', $path.'shortvar.list');
    });


    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix('/systems'),
    ],
        function (\Illuminate\Routing\Router $router, $path = 'dashboard.systems.recycle.') {
            $router->screen('recycle/{id}/edit', 'Recycle\RecycleEdit', $path.'edit');
            $router->screen('recycle', 'Recycle\RecycleList', $path.'list');
        });

});
