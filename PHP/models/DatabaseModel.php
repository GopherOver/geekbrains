<?php

namespace models;


use core\Application;

/**
 * Class DatabaseModel
 * @package models
 */
abstract class DatabaseModel
{

    private static function parseWhere(array $where)
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

    public static function findOne(array $where = [])
    {
        $query = 'SELECT * FROM ' . static::TABLE_NAME;

        if (!empty($where))
            $query .= self::parseWhere($where);

        $query .= ' LIMIT 1';

        return self::execute($query, [], false);
    }

    /**
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