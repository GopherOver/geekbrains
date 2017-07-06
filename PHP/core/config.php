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
            '/'                             => 'main/index', // главная страница
            '/user/register'                => 'user/register', // страница регистрации
            '/user/login'                   => 'user/login', // страница входа
            '/user/logout'                  => 'user/logout',
            '/user'                         => 'user/index', // страница "личного кабинета"
            '/shop/view/product/:num'       => 'shop/viewProduct/$1',
            '/shop'                         => 'shop/index',

            '/admin/order/statusChange'     => 'admin/statusChange',
            '/admin'                        => 'admin/index',
            '/:any'                         => 'main/error' // все остальные запросы обрабатываются здесь
        ]
    ];
}