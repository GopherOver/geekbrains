<?php

namespace models;


class ProductModel extends DatabaseModel
{
    protected $_table = 'product';

    public function getProductByID($id)
    {
        $data = [
            'product' => $this->findId($id),
            'images' => $this->getImagesByProductID($id)
        ];

        return $data;
    }

    public function getImagesByProductID($id)
    {
        $where = ' `product_id` = ' . $id;
        return $this->findAll('product_img', $where);
    }

}