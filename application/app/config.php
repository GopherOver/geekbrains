<?php

function getConfig()
{
    return [
        'db' => [
            'host' => 'localhost',
            'name' => 'l5.gb',
            'user' => 'root',
            'pass' => '1'
        ],
        /**
         * 'url' => 'контроллер/действие/параметр1/параметр2/параметр3'
         * :num - для чисел
         * :str - для букв
         * :any - для чисел и букв
         * $1,$2,$3... - номера параметров
         */
        'routes' => [
            '/'                 => 'main/index', // главная страница
            '/user/register'    => 'user/register', // страница регистрации
            '/user/login'       => 'user/login', // страница входа
            '/user/logout'      => 'user/logout',
            '/user'             => 'user/index', // страница "личного кабинета"

            '/:any'             => 'main/error' // все остальные запросы обрабатываются здесь
        ]
    ];
}