<?php

namespace models;


class ProductModel extends DatabaseModel
{
    const Photo     = 0;
    const Size      = 1;
    const Color     = 2;
    const Category  = 3;

    public function getProductByID($id)
    {
        $data = [
            'product' => $this->findId($id),
            'properties' => (new ProductPropertyModel())->findAll([
                'product_id' => $id
            ])
        ];

        return $data;
    }

}