<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

/**
 * プロフィールページでの処理
 * 
 */
class ProfileController extends Controller
{
    /**
    * プロフィール編集画面
    *
    * @return \Illuminate\Http\Response
    */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
    * ユーザのプロフィール表示画面
    *
    * @param int id
    * @param bool $is_image ユーザのサムネイル画像がすでに保存されているか否か
    *
    * @return \Illuminate\Http\Response
    */
    public function show($id,$is_image = false)
    {
        
        $user = User::find($id);
        if($user == null) {
            abort('404');
        }

        if((int)$id === Auth::id()){
            return redirect('profile');
        }
        
        $is_image = $this->imageExists($id);
        
        return view('profile.show', compact('user','is_image')); 
    }

    /**
    * プロフィール変更情報の保存
    *
    * @param ProfileRequest $request
    *
    * @return \Illuminate\Http\Response
    */
    public function store(ProfileRequest $request)
    {
        // サムネイルを保存
        $user = Auth::user();
        $image_file = $request->file('thumbnail');
        if(!empty($image_file)){

            $path = Storage::disk('s3')->putFile('/', $image_file, 'public');

            $user->thumbnail = Storage::disk('s3')->url($path);
        }
        if($user->description !== $request->description){
            $user->description = $request->description;
        }
        if($user->name !== $request->name){
            $user->name = $request->name;
        }

        $user->save();
        return redirect()->route('profile');
    }

}
