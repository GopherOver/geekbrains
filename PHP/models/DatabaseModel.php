<?php

namespace models;


use core\Application;

/**
 * Class DatabaseModel
 * @package models
 */
abstract class DatabaseModel
{

    /**
     * Выстраиваем цепочку WHERE
     * @param array $where
     * @return string
     */
    private static function parseWhere(array $where)
    {
        $result = ' WHERE';
        $current = 0;
        foreach ($where as $col => $val)
        {
            if ($current > 0)
                $result .= ' AND';

            $result .= ' ' . $col . ' = "' . $val . '"';
            $current++;
        }

        return $result;
    }

    /**
     * Выстраиваем цепочку ORDER BY
     * @param array $orderBy
     * @param $desc
     * @return bool|string
     */
    private static function parseOrderBy(array $orderBy, $desc)
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

    /**
     * Ищем все поля, удовлетворяющие запросу
     * @param array $where
     * @param int $limit
     * @param array $orderBy
     * @param bool $desc
     * @return array|bool|mixed
     */
    public static function findAll(array $where = [], $limit = 10, $orderBy = [], $desc = true)
    {
        $query = 'SELECT * FROM ' . static::TABLE_NAME;

        if (!empty($where))
            $query .= self::parseWhere($where);

        $query .= ' LIMIT ' . (int)($limit);

        if (!empty($orderBy))
            $query .= self::parseOrderBy($orderBy, $desc);

        return self::execute($query, [], true);
    }

    /**
     * Ищем 1 позицию, удовлетворяющую запросу
     * @param array $where
     * @return array|bool|mixed
     */
    public static function findOne(array $where = [])
    {
        $query = 'SELECT * FROM ' . static::TABLE_NAME;

        if (!empty($where))
            $query .= self::parseWhere($where);

        $query .= ' LIMIT 1';

        return self::execute($query, [], false);
    }

    /**
     * Ищем по ID
     * @param $id
     * @return array|bool|mixed
     */
    public static function findId($id)
    {
        $query = 'SELECT * FROM '.static::TABLE_NAME. ' WHERE `id` = :id';

        $props = [
            'id' => $id
        ];

        return self::execute($query, $props);
    }

    /**
     * Запрос на добавление
     * @param array $data
     * @return array|bool|mixed
     */
    public static function insert(array $data)
    {
        $query = 'INSERT INTO '.static::TABLE_NAME;

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

        return self::execute($query, $props);
    }

    /**
     * Запрос на удаление
     * @param array $where
     * @return array|bool|mixed
     */
    public static function purge(array $where = [])
    {
        if (!empty($where))
            $where = self::parseWhere($where);

        $query = 'DELETE FROM ' . static::TABLE_NAME . $where;

        return self::execute($query, []);
    }

    /**
     * Выполнение запроса
     * @param $query
     * @param $props
     * @param bool $fetchAll
     * @return array|bool|mixed
     */
    public static function execute($query, $props, $fetchAll = false)
    {
        return Application::instance()->db()->execute($query, $props, $fetchAll);
    }

}