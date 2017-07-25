<?php

function getConfig()
{
    return [
        'db' => [
            'default' => [
                'host'      => 'localhost',
                'name'      => 'l5.gb',
                'charset'   => 'utf8',
                'user'      => 'root',
                'pass'      => '1'
            ],
        ],
        /**
         * 'url' => 'контроллер/действие/параметр1/параметр2/параметр3'
         * :num - для чисел
         * :str - для букв
         * :any - для чисел и букв
         * $1,$2,$3... - номера параметров
         */
        'routes' => [
            '/'                             => 'main/index',            // главная страница

            // Пользователь
            '/user/register'                => 'user/register',         // страница регистрации
            '/user/login'                   => 'user/login',            // страница входа
            '/user/logout'                  => 'user/logout',           // экшн выхода
            '/user/cart/order'              => 'user/cartOrder',        // страница оформления заказа
            '/user/cart'                    => 'user/cartIndex',        // страница корзины
            '/user'                         => 'user/index',            // страница "личного кабинета"

            // Магазин
            '/shop/view/product/:num'       => 'shop/viewProduct/$1',   // просмотр товара
            '/shop'                         => 'shop/index',            // все товары

            // Корзина
            '/cart/add'                     => '/user/addProductToUserCart', // Добавление товара в корзину
            '/cart/del'                     => '/user/removeProductFromUserCart', // Удаление товара из корзины
            '/cart/change'                  => '/user/changeQuantityProduct', // Удаление товара из корзины
            '/cart/clear'                   => '/user/clearUserCart',   // Очистка корзины

            // Администратор
            '/admin/order/statusChange'     => 'admin/statusChange',    // экшн смены статуса заказа
            '/admin'                        => 'admin/index',           // administrator's page

            '/:any'                         => 'main/error'             // все остальные запросы обрабатываются здесь
        ]
    ];
}