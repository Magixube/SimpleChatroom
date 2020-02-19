<?php

namespace App\Controllers;

use DateTime;

class UserValidator
{
    public static function isExists($user)
    {
        return $user !== null;
    }
    
    public static function isLogin($user, $token)
    {
        if (strcmp($user->access_token, $token) == 0) {
            $currTime = new DateTime('now');
            $expire_time = new DateTime($user->expire_time);
            if ($currTime < $expire_time) {
                return true;
            }
        }
        
        return false;
    }
}
