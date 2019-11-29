<?php

namespace App\Http\Controllers;

use App\Work;
use Illuminate\Http\Request;
use App\Http\Requests\WorkRequest;
use Illuminate\Support\Facades\Auth;

class WorksController extends Controller
{
    public function new()
    {
        return view('works.new');
    }

    public function create(WorkRequest $request)
    {
        $work = new Work;
        $user_id = Auth::id();

        // 案件の保存
        $work->user_id = $user_id;
        $work->fill($request->all())->save();

        return redirect('/works/new')->with('flash_message', __('Registered.'));

    }
}
