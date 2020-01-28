<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message_type','work_id','to_user_id','from_user_id','text'];

    /**
     * メッセージの送信者ユーザを取得
     * 
     * @return 
     */
    public function fromUser(){
        return $this->hasOne('App\User','id','from_user_id');
    }

    /**
     * メッセージの送信先ユーザを取得
     * 
     * @return 
     */
    public function toUser(){
        return $this->hasOne('App\User','id','to_user_id');
    }
}
