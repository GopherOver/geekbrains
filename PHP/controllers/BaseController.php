<?php

namespace controllers;

use models\ProductCategoryModel;
use models\UserModel;

class BaseController
{
    public function render($template = "index.tmpl", array $data, $layout = 'layouts/main')
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem('../views/'), array());
        $twig->addExtension(new \Twig_Extensions_Extension_Text());

        echo $twig->render($layout . '.tmpl', array(
            'template' => $template . '.tmpl',
            'menu' => (new ProductCategoryModel())->getMenu(),
            'user' => (new UserModel())->getUser(),
            'data' => $data
        ));
    }

    public function renderError()
    {
        $this->render("errors/404", []);
    }

    public function actionError()
    {
        $this->renderError();
    }

}