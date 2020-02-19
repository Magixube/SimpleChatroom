<?php
namespace App\Core\Database;

use Illuminate\database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    public $timestamps = false;
    protected $fillable = [
        'msg', 'time'
    ];

    public function user()
    {
        return $this->belongsTo('\App\Core\Database\User');
    }

    public function chatroom()
    {
        return $this->belongsTo('App\Core\Database\Chatroom', 'room_id');
    }
}
