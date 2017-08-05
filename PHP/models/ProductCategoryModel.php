<?php

namespace models;


/**
 * Class ProductCategoryModel
 * @package models
 */
class ProductCategoryModel extends BaseModel
{
    /**
     * Имя таблицы
     */
    const TABLE_NAME = 'products_categories';

    /**
     * Возвращаем дерево меню
     * @return array
     */
    public function getMenu()
    {
        $data = $this->findAll();

        $cat = [];

        for ($i = 0; $i < count($data); $i++)
        {

            if ($data[$i]['url'] == $_SERVER['REQUEST_URI'])
                $data[$i]['active'] = true;

            $cat[$data[$i]['id']] = $data[$i];
        }

        $tree = [];
        foreach ($cat as $id => $node) {
            //Если нет вложений
            if (empty($node['parent_id'])){
                $tree[$id] = $node;
            }else{
                //Если есть потомки то перебераем массив
                $tree[$node['parent_id']]['childs'][$id] = $node;
            }
        }

        return $tree;
    }
}