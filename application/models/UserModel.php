<?php

namespace models;


class UserModel extends BaseModel
{
    public function getUserData()
    {
        if (!$this->isAuth())
        {
            return [];
        }

        if (isset($_SESSION["email"]))
        {
            $user = $this->getUserByEmail($_SESSION["email"]);
            return ['user' => $user];
        }
    }

    public function isAuth()
    {
        return isset($_SESSION["is_auth"]) ? true : false;
    }

    private function userCreate($email, $password)
    {
        $exist = $this->getUserByEmail($email);
        if (!empty($exist))
        {
            return ["Такой Email уже используется!"];
        }

        $hash = $this->generate_hash($password);

        $query = 'INSERT
            INTO
                `user`(`id`, `email`, `hash`, `status`)
            VALUES(NULL, :email, :hash, :status);';

        $props = [
            "email" => $email,
            "hash" => $hash,
            "status" => 1
        ];

        return $this->execute($query, $props);
    }

    private function userAuth($email, $password)
    {
        $exist = $this->getUserByEmail($email);
        if (empty($exist))
        {
            return ['Email или пароль не верны!'];
        }

        $hash = $this->getUserHashByEmail($email);

        if (!$this->validate_pw($password, $hash['hash']))
        {
            return ['Email или пароль не верны!'];
        }

        $_SESSION["is_auth"] = true;
        $_SESSION["email"] = $email;

        return true;
    }

    private function getUserHashByEmail($email)
    {
        $query = 'SELECT
                `hash`
            FROM
                `user`
            WHERE
                `email` = :email;';

        $props = [
            "email" => $email
        ];

        return $this->execute($query, $props);
    }

    public function getUserByEmail($email)
    {
        $query = 'SELECT
                *
            FROM
                `user`
            WHERE
                `email` = :email';
        $props = [
            "email" => $email
        ];

        return $this->execute($query, $props);
    }


    public function doLogin()
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
            return $this->userAuth($email, $password);
    }

    public function doRegister()
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $password2 = trim($_POST['password2']);
        $errors = [];

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
            return $this->userCreate($email, $password);
    }

    public function doLogout()
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
    private function generate_hash($password, $cost=11)
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
    private function validate_pw($password, $hash)
    {
        /* Regenerating the with an available hash as the options parameter should
         * produce the same hash if the same password is passed.
         */
        return crypt($password, $hash)==$hash;
    }
}