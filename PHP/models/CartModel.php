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
                    p.id,
                    p.name,
                    p.category_id,
                    p.description,
                    p.img_src,
                    pp.value,
                    pp.type,
                    c.color,
                    c.size,
                    c.product_price,
                    c.amount,
                    pc.menu_name AS category_name,
                    pc.url AS category_url,
                    ppt.name AS type_name
                FROM
                    `carts` c
                INNER JOIN `products` p ON
                    p.id = c.product_id
                INNER JOIN `products_properties` pp ON
                    pp.product_id = p.id
                INNER JOIN `products_categories` pc ON
                    pc.id = p.category_id
                INNER JOIN `products_properties_types` ppt ON
                    ppt.id = pp.type
                WHERE
                    c.user_id = :user_id AND c.order_id IS NULL
                    ';

            $result = self::execute($query, ['user_id' => $userId], true);

            $data = [];

            foreach ($result as $key => $col) {
                if (empty($data[$col['id']]))
                    $data[$col['id']] = $col;
            }

            $data = ['cart_items' => array_values($data)];
            return $data;
        } else
            return false;
    }
}