<?php

namespace App\Core\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class DBConnection
{
    public static function make($config)
    {
        $capsule = new  Capsule;

        $capsule->addConnection($config);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }
}
