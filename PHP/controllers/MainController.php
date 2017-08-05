<?php

namespace controllers;


use models\ProductCategoryModel;
use models\ProductModel;

/**
 * Контроллер главной страницы
 * Class MainController
 * @package controllers
 */
class MainController extends BaseController
{
    /**
     * Главная страница
     */
    public function actionIndex()
    {
        $data = [
            'title' => 'Home',
            'products' => ProductModel::findAll()
        ];

        $this->render("main/index", $data);
    }
}