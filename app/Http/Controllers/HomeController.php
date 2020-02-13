<?php

namespace App\Http\Controllers;

use App\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MessageController;

/**
 * マイページでの処理
 * 
 */
class HomeController extends MessageController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {


        // ログインユーザに関連する案件を取得
        $posted_works = Auth::user()->postedWorks()->latest()->with('postUser')->get();
        $applied_works = Auth::user()->appliedWorks()->latest()->with('postUser')->get();
        $liked_works = Auth::user()->likedWorks()->latest()->with('postUser')->get();

        
        
        // ログインユーザに関連するメッセージを取得
        [
            "posted_works" =>$posted_works,
            "applied_works" =>$applied_works,
        ]
        = $this->getLatestMsgWorks($posted_works, $applied_works);

        

        return view('mypage',compact('posted_works','applied_works','liked_works'));
    }
}
