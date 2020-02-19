<?php

$router->post('/user/add', 'UserController@createUser');
$router->post('/user/login', 'UserController@login');
$router->post('/user/autologin', 'UserController@autoLogin');

$router->get('', 'PageController@index');
$router->get('/room/all', 'ChatroomController@getRoom');
$router->get('/message', 'MessageController@getMessage');
