<?php


namespace App\Helpers;


class PasswordHelper
{
    /**
     * hash user password with sha512 algo
     * @param string $password
     * @return string encrypted user password
     */
    public static function hashPassword(string $password):string
    {
        $salt = hash("md5", config("setup.salt"));
        $pass = "#" . hash("sha512", $password . $salt . strlen($password)) . "#";
        // prevent time attack
        // https://wiki.php.net/rfc/timing_attack
        usleep(rand(0, 1000));

        return $pass;
    }
}
