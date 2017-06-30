<?php

namespace controllers;


class MainController extends BaseController
{
    public function actionIndex()
    {
        $this->render("main/index.tmpl", array());
    }
}