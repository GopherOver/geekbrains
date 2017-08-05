<?php

namespace controllers;

use models\ProductCategoryModel;
use models\UserModel;

/**
 * Class BaseController
 * @package controllers
 */
class BaseController
{
    /**
     * Метод рендеринга
     * @param string $template - шаблон
     * @param array $data - данные
     * @param string $layout главный шаблон
     */
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

    /**
     * Рендерим ошибку
     */
    public function renderError()
    {
        $this->render("errors/404", []);
    }

    /**
     * Вызов ошибки
     */
    public function actionError()
    {
        $this->renderError();
    }

}