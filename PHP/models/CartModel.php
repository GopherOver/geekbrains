<?php

namespace models;


/**
 * Class CartModel
 * @package models
 */
class CartModel extends BaseModel
{
    /**
     * Имя таблицы
     */
    const TABLE_NAME = 'carts';

    /**
     * Получаем корзину пользователя по его ID
     * @param null $userId
     * @return array|bool
     */
    public static function getCartByUserId($userId = NULL)
    {
        if (!empty($userId)) {
            $query = '
                SELECT
                    c.id as cart_id,
                    p.id,
                    p.name,
                    p.category_id,
                    p.img_src,
                    c.color,
                    c.size,
                    c.product_price,
                    c.amount
                FROM
                    `'.self::TABLE_NAME.'` c
                INNER JOIN `products` p ON
                    p.id = c.product_id
                WHERE
                    c.user_id = :user_id AND c.order_id = 0
                    ';

            $result = self::execute($query, ['user_id' => $userId], true);

            $data = [];
            $total = 0;
            $length = 0;

            foreach ($result as $key => $col)
            {
                if (empty($data[$col['id']])) {
                    $data[$col['id']] = $col;
                } else {
                    $data[$col['id']]['amount'] += $col['amount'];
                }

                $data[$col['id']]['subtotal'] = $col['product_price'] * $data[$col['id']]['amount'];

                $length += $data[$col['id']]['amount'];
                $total += $data[$col['id']]['subtotal'];
            }

            $data = [
                'cartItems' => array_values($data),
                'cartAmount' => $total,
                'cartLength' => $length
            ];

            return $data;
        } else
            return false;
    }

    /**
     * Проверка на присутствие товара в корзине пользователя
     * @param $product
     * @param $userId
     * @return array|bool|mixed
     */
    public static function isExistProductIdInUserCart($product, $userId)
    {
        return self::findAll([
            'user_id'       => $userId,
            'product_id'    => $product['id_product'],
            'size'          => $product['size'],
            'color'         => $product['color'],
            'order_id'      => 0
        ], 1);
    }

    /**
     * Добавляем товар в корзину пользователя
     * @param $userId
     * @param $product
     * @return array|bool|mixed
     */
    public static function addProductToUserCart($userId, $product)
    {
        return self::insert([
            'user_id' => $userId,
            'product_id' => $product['id_product'],
            'size' => $product['size'],
            'color' => $product['color'],
            'amount' => $product['amount'],
            'product_price' => $product['product_price']
        ]);
    }

    /**
     * Удаляем товар из корзины пользователя
     * @param $userId
     * @param $productId
     * @return array|bool|mixed
     */
    public static function removeProductFromUserCart($userId, $cartId)
    {
        $exist = self::findId($cartId);

        if (empty($exist))
            return false;

        $query = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = '.$cartId;
        return self::execute($query, []);
    }

    /**
     * Очищаем корзину пользователя
     * @param $userId
     * @return array|bool|mixed
     */
    public static function clearUserCart($userId)
    {
        $cartProducts = self::findAll([
            'user_id' => $userId,
            'order_id' => '0'
        ]);

        if (empty($cartProducts))
            return false;

        $arr = [];

        foreach ($cartProducts as $key => $ids)
            $arr = array_merge($arr, [$ids['id']]);

        $query = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id in (' . implode(',', $arr) . ') AND order_id = 0';
        return self::execute($query, []);
    }

    /**
     * Инкрементируем количество товара в корзине пользователя на 1
     * @param $cartId
     * @return array|bool|mixed
     */
    public static function incQuantityProduct($cartId)
    {
        $query = 'UPDATE ' . self::TABLE_NAME . ' SET amount = amount + 1 WHERE id = ' . (int)($cartId);
        return self::execute($query, []);
    }

    /**
     * Изменяем количество товара в корзине пользователя
     * @param $cartId
     * @param $amount
     * @return array|bool|mixed
     */
    public static function changeQuantityProduct($cartId, $amount)
    {
        $query = 'UPDATE ' . self::TABLE_NAME . ' SET amount = ' . (int)($amount). ' WHERE id = ' . (int)($cartId);
        return self::execute($query, []);
    }
}