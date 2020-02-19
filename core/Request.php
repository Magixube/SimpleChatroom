<?php

namespace App\Core;

class Request
{
    public static function path()
    {
        return parse_url($_SERVER['PATH_INFO'], PHP_URL_PATH);
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
