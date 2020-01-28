<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = ['title', 'type_id', 'single_price_min', 'single_price_max', 'revenue_share_price', 'detail'];

    // 案件を投稿したユーザ
    public function postUser()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // 案件に応募したユーザ
    public function applyUsers(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
