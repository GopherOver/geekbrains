<?php

namespace controllers;

use models\CartModel;
use models\UserModel;

class UserController extends BaseController
{
    public function actionIndex()
    {
        if (!UserModel::isAuth())
        {
            header("Location: /");
            return;
        }

        $orders = UserModel::getUserOrders();
        $data = [];

        foreach ($orders as $key => $value)
            $data[$value['id']] = (isset($data[$value['id']])) ? array_merge( $data[$value['id']], [$value]) : [$value];

        $data = ['orders' => $data];

        $this->render("user/index", $data, 'layouts/user');
    }

    public function actionLogin()
    {
        if (UserModel::isAuth())
        {
            header("Location: /");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $errors = UserModel::doLogin();

            if (is_array($errors))
                $this->render("user/login", ['errors' => $errors], 'layouts/user');
            else if ($errors)
                header("Location: /user");
        }
        else {
            $this->render("user/login", [], 'layouts/user');
        }
    }

    public function actionLogout()
    {
        UserModel::doLogout();
        header("Location: /");
    }

    public function actionRegister()
    {
        if (UserModel::isAuth())
        {
            header("Location: /");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $errors = UserModel::doRegister();

            if (is_array($errors))
                $this->render("user/register", ['errors' => $errors]);
            else
                $this->render("user/register", ['successes' => ['Регистрация успешно завершена!']]);
        }
        else {
            $this->render("user/register", [], 'layouts/user');
        }
    }

    public function actionCartIndex()
    {
        if (!UserModel::isAuth())
        {
            header("Location: /");
            return;
        }

        $this->render("user/cart/index", [], 'layouts/user');
    }

    public function actionCartOrder()
    {
        $this->render("user/cart/order", [], 'layouts/user');
    }


    public function actionAddProductToUserCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!empty($_POST['data'])) {
                $user = UserModel::getUser();

                if (empty($user))
                    return;

                $product = json_decode($_POST['data'], true);

                if (empty($product))
                    return;

                if (empty($product['size']))
                    $product['size'] = 'M';

                if (empty($product['color']))
                    $product['color'] = 'black';

                if (empty($product['amount']))
                    $product['amount'] = '1';

                if (empty($product['product_price']))
                    $product['product_price'] = '52';

                CartModel::addProductToUserCart($user['id'], $product);

                echo 'success';
            }
        }
    }

    public function actionRemoveProductFromUserCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!empty($_POST['data'])) {
                $user = UserModel::getUser();

                if (empty($user))
                    return;

                $product = json_decode($_POST['data'], true);
                if (empty($product))
                    return;

                CartModel::removeProductFromUserCart($user['id'], $product['id']);

                echo 'success';
            }
        }
    }

    public function actionClearUserCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $user = UserModel::getUser();

            if (empty($user))
                return;

            CartModel::clearUserCart($user['id']);

            echo 'success';
        }
    }

    public function actionChangeQuantityProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $user = UserModel::getUser();

            if (empty($user))
                return;

            $data = json_decode($_POST['data'], true);

            if (empty($data))
                return;

            if (empty($data['cart_id']) || empty($data['amount']))
                return;

            CartModel::changeQuantityProduct($data['cart_id'], $data['amount']);

            echo 'success';
        }
    }
}