<?php

namespace controllers;


use models\OrderModels;
use models\OrderStatusModel;
use models\UserModel;

/**
 * Class AdminController
 * @package controllers
 */
class AdminController extends BaseController
{
    /**
     * Главная админ панели
     */
    public function actionIndex()
    {
        if (!UserModel::isAuth())
        {
            header("Location: /");
            return;
        }

        // Вытаскиваем заказы
        $orders = OrderModels::getAllOrdersWithUsers();
        $statuses = OrderStatusModel::findAll();

        $this->render("admin/index", ['orders' => $orders, 'statuses' => $statuses], 'layouts/admin');

    }

    /**
     * Изменение статуса из админки
     */
    public function actionStatusChange()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['data'])) {
                $data = json_decode($_POST['data'], true);

                $orderId    = $data['order_id'];
                $statusId   = $data['status_id'];

                OrderModels::setOrderStatus($orderId, $statusId);

                switch ($statusId) {
                    case 1: echo "danger";  break;
                    case 2: echo "warning"; break;
                    case 3: echo "info";    break;
                    case 4: echo "success"; break;
                }
            }

        }
    }
}