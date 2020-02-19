<?php

return [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'chatroom',
        'username' => 'root',
        'password' => 'lin00556',
        'charset' => 'utf8',
        'options' => [
            PDO::ATTR_EMULATE_PREPARES, false
        ]
    ],
    'JWT' => [
        'secret' => 'ijtugoieagtjmrei'
    ]
];
