<?php

namespace models;


class CartModel extends BaseModel
{
    const TABLE_NAME = 'carts';

    public static function getCartItemsByUserId($userId = NULL)
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
                    `carts` c
                INNER JOIN `products` p ON
                    p.id = c.product_id
                WHERE
                    c.user_id = :user_id AND c.order_id = 0
                    ';

            $result = self::execute($query, ['user_id' => $userId], true);

            $data = [];
            $amount = 0;
            $total = 0;

            foreach ($result as $key => $col)
            {
                $data[$col['id']] = $col;
                $data[$col['id']]['subtotal'] = $col['product_price'] * $col['amount'];
                $total += $data[$col['id']]['subtotal'];
                $amount++;
            }

            $data = [
                'cart_items' => array_values($data),
                'cart_amount' => $amount,
                'cart_total' => $total
            ];

            return $data;
        } else
            return false;
    }

    public static function addProductToUserCart($userId, $product)
    {
        return self::insert([
            'user_id' => $userId,
            'product_id' => $product['id'],
            'size' => $product['size'],
            'color' => $product['color'],
            'amount' => $product['amount'],
            'product_price' => $product['product_price']
        ]);
    }

    public static function removeProductFromUserCart($userId, $productId)
    {
        $exist = self::findAll([
            'user_id' => $userId,
            'product_id' => $productId,
            'order_id' => '0'
        ]);

        if (empty($exist))
            return false;

        $arr = [];

        foreach ($exist as $key => $ids)
            $arr = array_merge($arr, [$ids['id']]);

        $query = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id in (' . implode(',', $arr) . ') AND order_id = 0';

        return self::execute($query, []);
    }

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

    public static function changeQuantityProduct($cartId, $amount)
    {
        $query = 'UPDATE ' . self::TABLE_NAME . ' SET amount = ' . (int)($amount) . ' WHERE id = ' . (int)($cartId);

        return self::execute($query, []);
    }
}