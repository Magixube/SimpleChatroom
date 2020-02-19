<?php

namespace App\Controllers;

use App\Core\Database\Chatroom;
use App\Core\Database\User;
use App\Core\App;
use Firebase\JWT\JWT;

class ChatroomController
{
    public function createRoom()
    {
        $data = loadPostData();
        $user = $this->getUserFromJWT($data['userId']);
        if (UserValidator::isExists($user) && UserValidator::isLogin($user, $data['token'])) {
            $chatroom = Chatroom::where('name', $data['roomname']->first());
            if (!$this->roomExists($chatroom)) {
                $chatroom = new Chatroom;
                $chatroom->name = $data['roomname'];
                $chatroom->create_by()->associate($user);
                $chatroom->save();
                responseData(204);
            } else {
                responseData(
                    409,
                    json_encode(array("message" => "Room is exists."))
                );
            }
        } else {
            responseData(
                401,
                json_encode(array("message" => "Please signin."))
            );
        }
    }

    public function getRoom()
    {
        $rooms = Chatroom::all(array('id', 'name'));
        responseData(200, $rooms->toJson());
    }

    private function roomExists($chatroom)
    {
        return $chatroom !== null;
    }

    private function getUserFromJWT($jwt)
    {
        $payload = (array) JWT::decode($jwt, App::get('config')['JWT']['secret'], array('HS256'));
        return User::where('id', $payload['id'])->first();
    }
}
