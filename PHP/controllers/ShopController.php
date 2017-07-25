<?php

namespace controllers;


use models\ProductModel;

class ShopController extends BaseController
{
    public function actionIndex()
    {
        $data = ['products' => ProductModel::findAll()];

        $this->render("shop/index", $data);
    }

    public function actionViewProduct($id)
    {
        $data = ProductModel::getProductByID($id);

        if (empty($data))
            $this->renderError();
        else
            $this->render("shop/product", $data);
    }

}