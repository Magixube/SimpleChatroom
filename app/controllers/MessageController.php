<?php

namespace App\Controllers;

use App\Core\Database\Message;

class MessageController
{
    public function getMessage()
    {
        $messageId = $_GET['offset'] ?? 0;
        $roomId = $_GET['roomId'] ?? 0;
        if ($roomId) {
            $messages = Message::select('id', 'msg', 'user_id', 'time')->where('room_id', $roomId);
            $messages = $messageId? $messages->where('id', '<', $messageId): $messages;
            $messages = $messages->with(array('user' => function ($query) {
                $query->select('id', 'nickname');
            }))->latest('id')->take(10)->get();
            $messages->makeHidden(['user_id']);
            responseData(200, json_encode(array_reverse($messages->toArray())));
        } else {
            responseData(400, json_encode(array(
                "message"=>"There is something error"
            )));
        }
    }
}
