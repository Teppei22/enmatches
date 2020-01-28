<?php

namespace App;

use App\Work;
use Illuminate\Support\Facades\Log;
use App\Notifications\SendApplication;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','thumbnail','description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * パスワード再設定メールの送信
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * 応募後の案件投稿者への通知メールの送信
     *
     * @param  App\User  $apply_user
     * @param App\Work $work
     * @return void
     */
    public function sendApplicationNotification($apply_user, $work)
    {
        $this->notify(new SendApplication($apply_user, $work));
    }

    // ユーザが投稿する案件
    public function postedWorks()
    {
        return $this->hasMany('App\Work');

    }

    // ユーザが応募する案件
    public function appliedWorks()
    {
        return $this->belongsToMany('App\Work')->withTimestamps();
    }
}
