<?php

namespace controllers;

use app\Application;
use models\UserModel;

class UserController extends BaseController
{
    public function actionIndex()
    {
        $this->render("user/index.tmpl", array());
    }

    public function actionLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $errors = (new UserModel())->doLogin();

            if (is_array($errors))
                $this->render("user/login.tmpl", array('errors' => $errors));
            else
                Application::instance()->router->redirect("/user");
               // $this->render("user/login.tmpl", array('successes' => ['Успешно!']));
        }
        else {
            $this->render("user/login.tmpl", array());
        }
    }

    public function actionLogout()
    {
        (new UserModel())->doLogout();
        Application::instance()->router->redirect();
    }

    public function actionRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $user = new UserModel;
            $errors = $user->doRegister();

            if (is_array($errors))
                $this->render("user/register.tmpl", array('errors' => $errors));
            else
                $this->render("user/register.tmpl", array('successes' => ['Регистрация успешно завершена!']));
        }
        else {
            $this->render("user/register.tmpl", array());
        }
    }
}