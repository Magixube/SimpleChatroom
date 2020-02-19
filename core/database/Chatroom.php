<?php
namespace App\Core\Database;

use Illuminate\database\Eloquent\Model;

class Chatroom extends Model
{
    protected $table = 'chatroom';
    public $timestamps = false;
    protected $fillable = [
        'name', 'create_by'
    ];
    public function users()
    {
        return $this->belongsToMany('App\Core\Database\User', 'user_chatroom');
    }

    public function messages()
    {
        return $this->hasMany('App\Core\Database\Message');
    }

    public function create_by()
    {
        return $this->belongsTo('App\Core\Database\User');
    }
}
