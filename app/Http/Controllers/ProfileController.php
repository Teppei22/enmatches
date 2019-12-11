<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(){
        $is_image = false;
        if (Storage::disk('local')->exists('public/profile_thumbnail/' . Auth::id() . '.jpg')) {
            $is_image = true;
        }

        // 「$idがログインしている自分のid」か確認
        $user = Auth::user();
        return view('profile.edit', compact('user','is_image')); 
    }

    public function store(ProfileRequest $request){
        // サムネイルを保存
        $user = User::find(Auth::id());
        if($request->thumbnail){
            $request->thumbnail->storeAs('public/profile_thumbnail', Auth::id() . '.jpg');
            $user->thumbnail = $request->thumbnail;
        }
        if($request->description){
            $user->description = $request->description;
        }
        $user->name = $request->name;
        $user->save();
        return redirect('profile')->with('flash_message', __('Registered.'));
    }
}
