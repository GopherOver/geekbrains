<?php

namespace models;



class BaseModel extends DatabaseModel
{

    /*
     * Deprecated __construct()
     *
     * DatabaseModel constructor.
     * задаём название таблицы, исходя из названия модели
     * Название модели -> название таблицы
     * UserModel -> users
     * OneOtherModel -> ones_others
     */

    /*public function __construct()
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
    }*/

}