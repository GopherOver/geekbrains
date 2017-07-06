<?php

namespace controllers;


use models\ProductModel;

class ShopController extends BaseController
{
    public function actionIndex()
    {
        $data = ['products' => (new ProductModel())->findAll()];

        $this->render("shop/index", $data);
    }

    public function actionViewProduct($id)
    {
        $data = (new ProductModel())->getProductByID($id);
        if (!$data['product'])
            $this->renderError();
        else
            $this->render("shop/view/product", $data);
    }

}