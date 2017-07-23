<?php

namespace models;


class ProductCategoryModel extends BaseModel
{
    const TABLE_NAME = 'products_categories';
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