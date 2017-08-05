<?php

namespace controllers;


use models\ProductModel;

/**
 * Контроллер магазина
 * Class ShopController
 * @package controllers
 */
class ShopController extends BaseController
{
    /**
     * /shop?params...
     * @param null $params
     */
    public function actionIndex($params = NULL)
    {
        if (!empty($params)){
            if ($params['category']){
                $data = ProductModel::getProductsByCategoryID($params['category']);
                $this->render("shop/index", $data);
                return;
            }
            if ($params['product']){
                $data = ProductModel::getProductByID($params['product']);
                $this->render("shop/product", $data);
                return;
            }
        }

        $data = ['products' => ProductModel::findAll()];
        $this->render("shop/index", $data);
    }

}