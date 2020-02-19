<?php
/**
 * Index
 * PHP version 7.2
 *
 * @package App/Chatrooom
 * @author  Magixube <o2336151@gmail.com>
 */

require './vendor/autoload.php';

require 'core/bootstrap.php';

use App\Controllers\ChatroomController;
use App\Core\Request;
use App\Core\Router;

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header(
            "Access-Control-Allow-Headers:"
            ."{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}"
        );
    }
    exit(0);
}

Router::load('route.php')->direct(Request::path(), Request::method());
