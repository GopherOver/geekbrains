<?php

namespace models;


class ProductModel extends BaseModel
{
    const TABLE_NAME = 'products';
    const Photo     = 1;
    const Size      = 2;
    const Color     = 3;
    const Material  = 4;
    const Designer  = 5;
    const Related   = 6;

    public static function getProductByID($id)
    {
        $query = '
            SELECT
                p.id,
                p.name,
                p.category_id,
                p.price,
                p.description,
                pp.value,
                pp.type,
                pc.menu_name as category_name,
                pc.url as category_url,
                ppt.name as type_name
            FROM
                `products` p
            INNER JOIN `products_properties` pp ON
                pp.product_id = p.id
            INNER JOIN `products_categories` pc ON
                pc.id = p.category_id
            INNER JOIN `products_properties_types` ppt ON
                ppt.id = pp.type
            WHERE
                p.id = :id
            ';

        $props = [
            'id' => $id
        ];

        $result = self::execute($query, $props, true);

        $data = [];

        foreach ($result as $key => $col)
        {
            if (empty($data))
                $data = $col;

            foreach ($col as $type => $value)
            {
                if (is_array($data[$col['type_name']]))
                    $data[$col['type_name']] += [
                        $key => [
                            'value' => $col['value'],
                        ]
                    ];
                else
                    $data[$col['type_name']] = [
                        $key => [
                            'value' => $col['value'],
                        ]
                    ];
            }
            $data[$col['type_name']] = array_values($data[$col['type_name']]);
        }

        unset($data['value']);
        unset($data['type']);
        unset($data['type_name']);

        if (!empty($data['related']))
        {
            $arr = [];

            foreach ($data['related'] as $key => $ids)
                $arr = array_merge($arr, [$ids['value']]);

            $query2 = 'SELECT * FROM `products` WHERE id in (' . implode(',', $arr) . ')';
            $related = self::execute($query2, [], true);

            $data['related'] = $related;
        }

        $data = ['product' => $data];

        return $data;
    }

    public static function getProductsByCategoryID($categoryId)
    {
        $query = '
            SELECT
                p.id,
                p.name,
                p.category_id,
                p.price,
                p.description,
                pp.value,
                pp.type,
                pc.menu_name as category_name,
                pc.url as category_url,
                ppt.name as type_name
            FROM
                `products` p
            INNER JOIN `products_properties` pp
            INNER JOIN `products_categories` pc ON
                pc.id = p.category_id
            INNER JOIN `products_properties_types` ppt ON
                ppt.id = pp.type
            WHERE
                p.category_id = :category_id
            ';

        $props =[
            'category_id' => $categoryId
        ];

        $result = self::execute($query, $props, true);

        $data = [];

        // TODO:  все свойства копируются в каждый продукт ( условие по product.id??? )

        foreach ($result as $key => $col)
        {
            if (empty($data[$col['id']]))
                $data[$col['id']] = $col;

            foreach ($col as $type => $value)
            {
                if (is_array($data[$col['id']][$col['type_name']]))
                    $data[$col['id']][$col['type_name']] += [
                        $key => [
                            'value' => $col['value'],
                        ]
                    ];
                else
                    $data[$col['id']][$col['type_name']] = [
                        $key => [
                            'value' => $col['value'],
                        ]
                    ];
            }
           // $data[$col['id']][$col['type_name']] = array_values($data[$col['id']][$col['type_name']]);
        }

        //$data = ['products' => array_values($data)];
        $data = ['products' => $data];

        return $data;
    }

}