<?php

namespace App\Http\Controllers;

use App\User;
use App\Work;
use App\WorkTypes;
use Illuminate\Http\Request;
use App\Http\Requests\WorkRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WorksController extends Controller
{
    public function new()
    {
        $work_types = WorkTypes::all();
        return view('works.new', compact('work_types'));
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

    public function index(){
        $works = Work::all();
        $users = User::all();
        $work_types = WorkTypes::all();
        // Log::info($users);
        // Log::info(array_column($users, 'id'));
        return view('works.index', compact('works','work_types','users'));
    }

    // public function searchUser($work_id){
    //     $user = DB::table('users')->where('id', $work_id)->first();
    //     return $user;
    // }
}
