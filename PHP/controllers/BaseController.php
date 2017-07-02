<?php

namespace controllers;


use models\UserModel;

class BaseController
{
    public function render($template = "index.tmpl", array $data)
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem('../views/'), array());
        $twig->addExtension(new \Twig_Extensions_Extension_Text());

        $userData = (new UserModel())->getUserData();
        $array = array_merge($data, $userData);

        echo $twig->render('layout/main.tmpl', array(
            "template" => $template,
            "data" => $array
        ));
    }

    public function renderError()
    {
        $this->render("errors/404.tmpl", []);
    }

    public function actionError()
    {
        $this->renderError();
    }

}