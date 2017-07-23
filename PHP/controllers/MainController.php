<?php

namespace controllers;


use models\ProductCategoryModel;
use models\ProductModel;

class MainController extends BaseController
{
    public function actionIndex()
    {
        $data = [
            'title' => 'Home',
            'products' => ProductModel::findAll()
        ];
        $this->render("main/index", $data);
    }
}