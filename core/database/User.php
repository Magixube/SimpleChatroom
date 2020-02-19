<?php
namespace App\Core\Database;

use Illuminate\database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    public $timestamps = false;
    protected $hidden = [
        'access_token'
    ];
    protected $fillable = [
        'email',
        'password',
        'nickname',
        'access_token',
        'expire_time'
    ];

    public function chatrooms()
    {
        return $this->belongsToMany('App\Core\Database\Chatroom', 'user_chatroom');
    }
}
