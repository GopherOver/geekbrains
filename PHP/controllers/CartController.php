<?php

namespace controllers;

use models\CartModel;
use models\ProductModel;
use models\UserModel;

/**
 * Корзина
 * Class CartController
 * @package controllers
 */
class CartController
{
    /**
     * Вытаскиваем корзину текущего пользователя
     */
    public function actionGetCart()
    {
        $user = UserModel::getUser();

        if (empty($user)){
            $response = ['error' => 'Пользователь не найден!'];
            echo $response;
            return;
        }

        $cart = CartModel::getCartByUserId($user['id']);

        if (empty($cart)){
            $response = ['error' => 'Корзина не найдена!'];
            echo $response;
            return;
        }

        $response = json_encode($cart);
        echo $response;
    }

    /**
     * Изменение количество товара
     */
    public function actionChangeQuantityProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            if (empty($_POST['data']))
            {
                $response = ['error' => 'Данные не найдены!'];
                echo $response;
                return;
            }

            $user = UserModel::getUser();

            if (empty($user))
            {
                $response = ['error' => 'Пользователь не найден!'];
                echo $response;
                return;
            }

            $data = $_POST['data'];

            if (empty($data['cart_id']) || empty($data['cartAmount']))
            {
                $response = ['error' => 'Пустое тело сообщение!'];
                echo $response;
                return;
            }

            CartModel::changeQuantityProduct($data['cart_id'], $data['cartAmount']);
        }
    }

    /**
     * Добавление продукта в корзину
     */
    public function actionAddProductToUserCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $user = UserModel::getUser();

            if (empty($user)){
                $response = ['error' => 'Пользователь не найден!'];
                echo $response;
                return;
            }

            $data = $_POST['data'];

            if (empty($data)){
                $response = ['error' => 'Данные не найдены!'];
                echo $response;
                return;
            }

            $product = ProductModel::findId($data['id_product']);

            if (empty($product)){
                $response = ['error' => 'Товар не найден!'];
                echo $response;
                return;
            }

            // Значения по умолчанию
            if (empty($data['user_id']))
                $data['user_id'] = $user['id'];

            if (empty($data['size']))
                $data['size'] = 'M';

            if (empty($data['color']))
                $data['color'] = 'black';

            if (empty($data['amount']))
                $data['amount'] = '1';

            if (empty($data['product_price']))
                $data['product_price'] = $product['price'];

            // Узнаём, есть ли товар с таким же ID в корзине пользователя
            $exist = CartModel::isExistProductIdInUserCart($data, $user['id']);

            // Если есть, то инкрементируем значение на 1 (кнопка Add to cart)
            if ($exist[0]['id']) {
                $error = CartModel::incQuantityProduct($exist[0]['id']);
            } else { // Если нету - добавляем
                $error = CartModel::addProductToUserCart($user['id'], $data);
            }

            // Формируем ответ
            $response = [
                "item" => [
                    "id_product" => $data['id_product'],
                    "price" => $product['price'],
                    "exist" => $exist,
                    "error" => $error
                ]
            ];

            echo json_encode($response);
        }
    }

    /**
     * Удаление товара из корзины
     */
    public function actionRemoveProductFromUserCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!empty($_POST['data'])) {
                $user = UserModel::getUser();

                if (empty($user)){
                    $response = json_encode(['error' => 'Пользователь не найден!']);
                    echo $response;
                    return;
                }

                $cartId = $_POST['data']['cart_id'];

                if (empty($cartId)){
                    $response = json_encode(['error' => 'Товар не найден!']);
                    echo $response;
                    return;
                }

                CartModel::removeProductFromUserCart($user['id'], $cartId);
            }
        }
    }

    /**
     * Очистка всей корзины
     */
    public function actionClearUserCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $user = UserModel::getUser();

            if (empty($user)){
                $response = json_encode(['error' => 'Пользователь не найден!']);
                echo $response;
                return;
            }

            CartModel::clearUserCart($user['id']);
        }
    }

}