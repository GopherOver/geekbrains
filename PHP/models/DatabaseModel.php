<?php

namespace models;


use core\Application;

/**
 * Class DatabaseModel
 * @package models
 */
abstract class DatabaseModel
{
    protected $_table;

    /**
     * DatabaseModel constructor.
     * задаём название таблицы, исходя из названия модели
     * Название модели -> название таблицы
     * UserModel -> users
     * OneOtherModel -> ones_others
     */
    public function __construct()
    {
        $className = explode('\\', get_called_class());
        $delimiter = preg_split('/(?<=[a-z])(?=[A-Z])/u', end($className));
        array_pop($delimiter);

        if (count($delimiter))
        {
            $tableName = str_replace('ys', 'ies', strtolower(implode('s_', $delimiter)) . 's');
            $tableName = str_replace('ss', 'ses', $tableName);
        }
        else
            $tableName = strtolower($delimiter[0]) . 's';

        $this->_table = $tableName;
    }

    private function parseWhere(array $where)
    {
        $result = ' WHERE';
        $current = 0;
        foreach ($where as $col => $val)
        {
            if ($current > 0)
                $result .= ' AND';

            $result .= ' `' . $col . '` = "' . $val . '"';
            $current++;
        }

        return $result;
    }

    private function parseOrderBy(array $orderBy, $desc)
    {
        $result = ' ORDER BY';
        foreach ($orderBy as $key => $val)
        {
            if ($key > 0)
                $result .= ' ,';

            $result .= ' `' . $val . '`';
        }

        $result = substr($result, 0, -2);

        $result .= $desc ? ' DESC' : 'ASC';

        return $result;
    }

    public function findAll(array $where = [], $limit = 10, $orderBy = [], $desc = true)
    {
        $query = 'SELECT * FROM ' . $this->_table;

        if (!empty($where))
            $query .= $this->parseWhere($where);

        $query .= ' LIMIT ' . (int)($limit);

        if (!empty($orderBy))
            $query .= $this->parseOrderBy($orderBy, $desc);

        return $this->execute($query, [], true);
    }

    public function findOne(array $where = [])
    {
        $query = 'SELECT * FROM ' . $this->_table;

        if (!empty($where))
            $query .= $this->parseWhere($where);

        $query .= ' LIMIT 1';

        return $this->execute($query, [], false);
    }

    /**
     * @param $id
     * @return array|bool|mixed
     */
    public function findId($id)
    {
        $query = 'SELECT * FROM '.$this->_table. ' WHERE `id` = :id';

        $props = [
            'id' => $id
        ];

        return $this->execute($query, $props);
    }

    /**
     * @param array $data
     * @return array|bool|mixed
     */
    public function insert(array $data)
    {
        $query = 'INSERT INTO '.$this->_table;

        $colData = ' (';
        $valData = ' VALUES(';
        $props = [];

        foreach ($data as $col => $val)
        {
            $colData .= '`' . $col .'`, ';
            $valData .= ':' . $col . ', ';
            $props = array_merge($props, [$col => $val]);
        }

        $colData = substr($colData, 0, -2) . ')';
        $valData = substr($valData, 0, -2) . ')';

        $query .= $colData . $valData;

        return $this->execute($query, $props);
    }

    /**
     * @param $query
     * @param $props
     * @param bool $fetchAll
     * @return array|bool|mixed
     */
    public function execute($query, $props, $fetchAll = false)
    {
        return Application::instance()->db()->execute($query, $props, $fetchAll);
    }

}