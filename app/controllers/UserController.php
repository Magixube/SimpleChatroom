<?php

namespace App\Controllers;

use App\Core\Database\User;
use DateTime;
use Firebase\JWT\JWT;
use APP\Core\App;
use App\Controllers\UserValidator;

class UserController
{
    private $manager;

    public function __construct()
    {
        $this->manager = new UserManager('App\Core\Database\User');
    }
    public function createUser()
    {
        $data = loadPostData();
        $user = $this->manager->getUserByEmail($data['email']);
        if (!$user) {
            $token = bin2hex(random_bytes(64));
            
            if (!empty($data['email']) &&
                !empty($data['password']) &&
                !empty($data['nickname'])) {
                $user = $this->manager->createNewUser([
                    'email' => $data['email'],
                    'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                    'nickname' => $data['nickname'],
                    'expire_time' => new DateTime('+1 week'),
                    'access_token' => $token
                ]);
                $jwt_payload = [
                    'id' => $user->id,
                    'nickname' => $user->nickname,
                ];
                responseData(200, json_encode(array(
                        'token' => $token,
                        'userId' => JWT::encode($jwt_payload, App::get('config')['JWT']['secret']),
                        'user' => array(
                            'id' => $user->id,
                            'nickname' => $user->nickname
                        )
                )));
            } else {
                responseData(400, json_encode(array(
                    "message" => "There was something wrong"
                )));
            }
        } else {
            responseData(409, json_encode(array(
                "message" => "This email already registered."
            )));
        }
    }

    public function login()
    {
        $data = loadPostData();
        $user = $this->manager->getUserByEmail($data['email']);
        if ($user &&
            password_verify($data['password'], $user->password)) {
            $token = bin2hex(random_bytes(64));
            $jwt_payload = [
                'id' => $user->id,
                'nickname' => $user->nickname,
            ];
            $this->manager->updateUser($user, [
                'expire_time' => new DateTime('+1 week'),
                'access_token' => $token
            ]);
            responseData(200, json_encode(array(
                    'token' => $token,
                    'userId' => JWT::encode($jwt_payload, App::get('config')['JWT']['secret']),
                    'user' => array(
                        'id' => $user->id,
                        'nickname' => $user->nickname
                    )
            )));
        } else {
            responseData(400, json_encode(array(
                "message" => "There was something wrong"
            )));
        }
    }

    public function autoLogin()
    {
        $data = loadPostData();
        $payload = (array) JWT::decode($data['userId'], App::get('config')['JWT']['secret'], array('HS256'));
        $user = User::where('id', $payload['id'])->first();
        if (UserValidator::isExists($user)) {
            if (UserValidator::isLogin($user, $data['token'])) {
                responseData(204);
            } else {
                responseData(
                    401,
                    json_encode(array("message" => "Token was expired."))
                );
            }
        } else {
            responseData(
                400,
                json_encode(array("message" => "There was something wrong"))
            );
        }
    }
}
