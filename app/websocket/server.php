<?php

namespace App\Websocket;

use Redis;
use Swoole;
use DateTime;
use App\Controllers\UserValidator;
use App\Core\Database\Chatroom;
use App\Core\App;
use App\Core\Database\Message;
use App\Core\Database\User;
use Firebase\JWT\JWT;

class Server
{

    protected $server;

    protected $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1');
        $this->server = new Swoole\WebSocket\Server("localhost", 9501);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('close', [$this, 'onClose']);
        $this->server->start();
    }

    public function onMessage($server, $frame)
    {
        if ($frame->data != null) {
            $data = json_decode($frame->data, true);
            echo 'receive from:' . $frame->fd . ' data:' . $frame->data . PHP_EOL;
            if (!empty($data['event'])) {
                $callback = 'on'.$data['event'];
                $this->$callback($frame->fd, $data['data']);
            }
        }
    }

    public function onClose($server, $fd, $reactorId)
    {
        $room = $this->redis->get('fd'.$fd);
        echo "fd:{$fd} close {$room}".PHP_EOL;
        $this->redis->sRem($room, $fd);
        $this->redis->del('fd'.$fd);
    }

    public function onEnter($fd, $data)
    {
        if (!empty($data['roomId']) && ($room = Chatroom::where('id', $data['roomId'])->first())) {
            $this->redis->sAdd($room->name, $fd);
            $this->redis->set('fd'.$fd, $room->name);
            echo 'fd:'.$fd.' enter '.$room->name.PHP_EOL;
        }
    }

    public function onLeave($fd, $data)
    {
        if (!empty($data['roomId']) && ($room = Chatroom::where('id', $data['roomId'])->first())) {
            echo 'fd:'.$fd.' close '.$room->name.PHP_EOL;
            $this->redis->sRem($room->name, $fd);
            $this->redis->del('fd'.$fd);
        }
    }

    public function send($room, $data)
    {
        $members = $this->redis->sMembers($room);

        foreach ($members as $fd) {
            $this->server->push($fd, json_encode($data));
        }
    }

    public function onChat($fd, $data)
    {
        if (!empty($data['token']) && !empty($data['userId'])) {
            $payload = (array) JWT::decode($data['userId'], App::get('config')['JWT']['secret'], array('HS256'));
            $user = User::where('id', $payload['id'])->first();
            if ($user && UserValidator::isLogin($user, $data['token'])) {
                if ($room = Chatroom::where('id', $data['roomId'])->first()) {
                    $message = new Message();
                    $message->user_id = $user->id;
                    $message->room_id = $room->id;
                    $message->msg = $data['message'];
                    $message->time = new DateTime('now');
                    $message->save();

                    $this->send($room->name, [
                        'event' => 'chat',
                        'data' => [
                            'id' => $message->id,
                            'msg' => $message->msg,
                            'time' => $message->time,
                            'user' => [
                                'id' => $user->id,
                                'nickname' => $user->nickname
                            ]
                        ]
                    ]);
                }
            }
        }
    }
}
