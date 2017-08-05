<?php

namespace controllers;

use models\CartModel;
use models\UserModel;

/**
 * Class UserController
 * @package controllers
 */
class UserController extends BaseController
{
    /**
     * TODO
     */
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

    /**
     * Страница входа на сайт
     */
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
                header("Location: /user/cart");
        }
        else {
            $this->render("user/login", [], 'layouts/user');
        }
    }

    /**
     * Выходим из аккаунта
     */
    public function actionLogout()
    {
        UserModel::doLogout();
        header("Location: /");
    }

    /**
     * Страница регистрации пользователя
     */
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

    /**
     * Страница корзины пользователя
     */
    public function actionCartIndex()
    {
        if (!UserModel::isAuth())
        {
            header("Location: /");
            return;
        }

        $user = UserModel::getUser();

        CartModel::getCartByUserId($user['id']);

        $this->render("user/cart/index", [], 'layouts/user');
    }

    /**
     * Страница оформления заказа
     */
    public function actionCartOrder()
    {
        $this->render("user/cart/order", [], 'layouts/user');
    }
}