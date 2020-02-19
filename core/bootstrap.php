<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/App.php';

use App\Core\Database\DBConnection;
use APP\Core\App;

App::bind('config', require 'config.php');

DBConnection::make(App::get('config')['database']);

function loadPostData()
{
    $post = file_get_contents('php://input');
    return json_decode($post, true);
}

function responseData($http_code, $data = '')
{
    header('Content-Type: application/json');
    http_response_code($http_code);
    if ($data)
        echo $data;
}