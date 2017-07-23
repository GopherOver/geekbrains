<?php

namespace models;


class UserModel extends BaseModel
{
    const TABLE_NAME = 'users';

    public static function getUserOrders($userId = NULL)
    {
        if (empty($userId))
        {
            $user = self::getUser();
            $userId = $user['id'];
        }

        $query = '
                SELECT
                    c.id,
                    o.id,
                    c.product_id,
                    o.created_at,
                    o.status,
                    o.amount,
                    os.status_name,
                    os.css,
                    p.name,
                    p.price
                FROM
                    `orders` o
                LEFT JOIN `carts` c ON
                    c.order_id = o.id
                LEFT JOIN `products` p ON
                    p.id = c.product_id
                LEFT JOIN `orders_statuses` os ON
                    o.status = os.id
                WHERE
                    o.user_id = :user_id
                ORDER BY
                    o.created_at
                DESC';

        $result = self::execute($query, ['user_id' => $userId], true);

        return $result;
    }

    public static function getUser()
    {
        if (!self::isAuth())
        {
            return [];
        }

        if (isset($_SESSION["email"]))
        {
            $user               = self::getUserByEmail($_SESSION["email"]);
            $user['cart']       = CartModel::getCartItemsByUserId($user['id']);
            $user['is_auth']    = true;

            return $user;
        }
    }

    public static function isAuth()
    {
        return isset($_SESSION["is_auth"]) ? true : false;
    }

    private static function userCreate($email, $password)
    {
        $exist = self::getUserByEmail($email);
        if (!empty($exist))
        {
            return ["Такой Email уже используется!"];
        }

        $hash = self::generate_hash($password);

        return self::insert([
            "email" => $email,
            "hash" => $hash
        ]);
    }

    private static function userAuth($email, $password)
    {
        $exist = self::getUserByEmail($email);
        if (empty($exist))
        {
            return ['Email или пароль не верны!'];
        }

        if (!self::validate_pw($password, $exist['hash']))
        {
            return ['Email или пароль не верны!'];
        }

        $_SESSION["is_auth"] = true;
        $_SESSION["email"] = $email;

        return true;
    }

    public static function getUserByEmail($email)
    {
        return self::findOne([
            'email' => $email
        ]);
    }


    public static function doLogin()
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $errors = [];

        if (empty($email) || empty($password))
        {
            if ((empty($email)))
                $errors = array_merge($errors, ['Поле email не должно быть пустым!']);

            if ((empty($password)))
                $errors = array_merge($errors, ['Поле пароля не должно быть пустым!']);
        }

        if ($errors)
        {
            return $errors;
        } else
            return self::userAuth($email, $password);
    }

    public static function doRegister()
    {
        $email      = trim($_POST['email']);
        $password   = trim($_POST['password']);
        $password2  = trim($_POST['password2']);
        $errors     = [];

        if (empty($email) || empty($password) || empty($password2))
        {
            if ((empty($email)))
                $errors = array_merge($errors, ['Поле email не должно быть пустым!']);

            if ((empty($password)))
                $errors = array_merge($errors, ['Поле пароля не должно быть пустым!']);

            if ((empty($password2)))
                $errors = array_merge($errors, ['Поле повтора пароля не должно быть пустым!']);
        }

        if ($password != $password2)
        {
            $errors = array_merge($errors, ['Пароли не совпадают!']);
        }

        if ($errors)
        {
            return $errors;
        } else
            return self::userCreate($email, $password);
    }

    public static function doLogout()
    {
        session_unset();
        session_destroy();
        return;
    }

    /*
    * Generate a secure hash for a given password. The cost is passed
    * to the blowfish algorithm. Check the PHP manual page for crypt to
    * find more information about this setting.
    */
    private static function generate_hash($password, $cost=11)
    {
        /* To generate the salt, first generate enough random bytes. Because
         * base64 returns one character for each 6 bits, the we should generate
         * at least 22*6/8=16.5 bytes, so we generate 17. Then we get the first
         * 22 base64 characters
         */
        $salt=substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
        /* As blowfish takes a salt with the alphabet ./A-Za-z0-9 we have to
         * replace any '+' in the base64 string with '.'. We don't have to do
         * anything about the '=', as this only occurs when the b64 string is
         * padded, which is always after the first 22 characters.
         */
        $salt=str_replace("+",".",$salt);
        /* Next, create a string that will be passed to crypt, containing all
         * of the settings, separated by dollar signs
         */
        $param='$'.implode('$',array(
                "2y", //select the most secure version of blowfish (>=PHP 5.3.7)
                str_pad($cost,2,"0",STR_PAD_LEFT), //add the cost in two digits
                $salt //add the salt
            ));

        //now do the actual hashing
        return crypt($password, $param);
    }

    /*
    * Check the password against a hash generated by the generate_hash
    * function.
    */
    private static function validate_pw($password, $hash)
    {
        /* Regenerating the with an available hash as the options parameter should
         * produce the same hash if the same password is passed.
         */
        return crypt($password, $hash)==$hash;
    }
}