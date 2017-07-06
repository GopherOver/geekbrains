<?php

namespace controllers;

use models\UserModel;

class UserController extends BaseController
{
    public function actionIndex()
    {
        if (!(new UserModel())->isAuth())
        {
            header("Location: /");
            return;
        }

        $orders = (new UserModel())->getUserOrders();
        $arr = [];

        foreach ($orders as $key => $value)
        {
            if (isset($arr[$value['id']]))
                $arr[$value['id']] = array_merge( $arr[$value['id']], [$value]);
            else
                $arr[$value['id']] = [$value];
        }
        $data = ['orders' => $arr];

        $this->render("user/index", $data);
    }

    public function actionLogin()
    {
        if ((new UserModel())->isAuth())
        {
            header("Location: /");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $errors = (new UserModel())->doLogin();

            if (is_array($errors))
                $this->render("user/login", ['errors' => $errors]);
            else if ($errors)
                header("Location: /user");
        }
        else {
            $this->render("user/login", []);
        }
    }

    public function actionLogout()
    {
        (new UserModel())->doLogout();
        header("Location: /");
    }

    public function actionRegister()
    {
        if ((new UserModel())->isAuth())
        {
            header("Location: /");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $user = new UserModel;
            $errors = $user->doRegister();

            if (is_array($errors))
                $this->render("user/register", ['errors' => $errors]);
            else
                $this->render("user/register", ['successes' => ['Регистрация успешно завершена!']]);
        }
        else {
            $this->render("user/register", []);
        }
    }
}