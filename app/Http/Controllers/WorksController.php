<?php

namespace App\Http\Controllers;

use App\User;
use App\Work;
use App\Message;
use App\WorkTypes;
use Illuminate\Http\Request;
use App\Http\Requests\WorkRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WorksController extends Controller
{
    // workタイプの対応表
    public $type =[
        "single" => 1,
        "revsh" =>2
    ];

    /**
    * 案件新規作成ページ作成
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $work_types = WorkTypes::all();
        return view('works.new', compact('work_types'));
    }

    /**
    * 案件編集機能
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $login_user = Auth::user();
        if($login_user->postedWorks()->where('id',$id)->doesntExist()){
            return redirect()->route('works.show',$id);
        }
        $work = $login_user->postedWorks()->find($id);
        $work_types = WorkTypes::all();
        return view('works.edit',compact('work','work_types'));
    }

    /**
    * 案件詳細ページ
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        
        $work = Work::find($id);
        if($work == null) {
            abort('404');
        }

        $user = User::find($work->user_id);
        $is_applied = $this->existsApplyUsers($work, Auth::user());
        $type = $this->type;
        
        return view('works.show', compact('work','user','type', 'is_applied'));
    }

    /**
    * 案件保存
    *
    * @param App\Http\Requests\WorkRequest $request
    * @return \Illuminate\Http\Response
    */
    public function store(WorkRequest $request)
    {
        $work = new Work;
        $user_id = Auth::id();

        // 案件の保存
        $work->user_id = $user_id;
        $work->fill($request->all())->save();

        return redirect()->route('works.show',$work->id);

    }

    /**
    * 案件編集後の更新
    *
    * @param App\Http\Requests\WorkRequest $request
    * @param int $id
    *
    * @return \Illuminate\Http\Response
    */
    public function update(WorkRequest $request, $id)
    {
        $work = Auth::user()->postedWorks()->find($id);

        if($work->type_id !== $request->type_id){
            if($request->type_id === 1){

                $work->revenue_share_price = null;

            }else if($request->type_id === 2){
                $work->single_price_min = null;
                $work->single_price_max = null;
            }
        }

        Auth::user()->postedWorks()->save($work->fill($request->all()));

        return redirect()->route('works.show',$id)->with('flash_message', __('Changed'));
    }

    /**
    * 案件削除
    *
    * @param int $id
    *
    * @return \Illuminate\Http\Response
    */
    public function delete($id)
    {

        $work = Auth::user()->postedWorks()->find($id);

        $work->delete();
        return redirect()->route('mypage')->with('flash_message',__('Deleted'));

    }

    /**
    * 案件一覧ページ処理
    *
    * @param Illuminate\Http\Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {

        $request->validate([
            'sort' => ['nullable','string','regex:/^(single|revsh|single_revsh)$/'],
            'keyword' => 'nullable|string',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            
        ]);
        $sort = $request->sort;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $keyword =  $request->keyword;
        
        session([
            'sort' => $sort,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'keyword' => $keyword
        ]);

        $works = Work::with(['postUser'])
            // 単発案件かレベニューシェア案件家で絞る
            ->where(function ($query)use($sort) {
                return $query->when($sort, function ($query)use($sort) {
                    if($sort !== 'single_revsh'){
                        return $query->where('type_id',$this->type[$sort]);
                    }else{
                        return $query;
                    }
                });
            })
            // 報酬金額で絞る
            ->where(function ($query)use($min_price){
                return $query->when($min_price || $min_price === '0', function ($query)use($min_price) {
                    return $query->Where('single_price_min', '>=' ,$min_price);
                    }
                );
            })
            ->where(function ($query)use($max_price){
                return $query->when($max_price || $max_price === '0', function ($query)use($max_price) {
                    return $query->Where('single_price_max', '<=' ,$max_price);
                    }
                );
            })
            
            
            // キーワード検索で絞る
            ->where(function($query)use($keyword){
                $query->when($keyword, function ($query) use($keyword) {
                    return $query->where('title','like','%'.$keyword.'%');
                });
            })
            ->latest()->paginate(10);

        $work_types = WorkTypes::all();

        return view('works.index', compact('works','work_types'));
    }

    /**
     * 特定案件にユーザが応募しているかを判定する
     *
     * @param App\Work $work
     * @param App\User $user
     * 
     * @return bool
     */
    public function existsApplyUsers($work, $user){

        if(!empty($user)){

            return DB::table('applies')->where('user_id', $user->id)->where('work_id', $work->id)->exists();

        }else{

            return false;
        }
        

    }

    /**
     * 特定案件にユーザがいいねしているかを判定する
     *
     * @param App\Work $work
     * @param App\User $user
     * 
     * @return bool
     */
    public function existsLikeUsers($work, $user){

        return DB::table('likes')->where('user_id', $user->id)->where('work_id', $work->id)->exists();

    }

    /**
    * 案件応募処理
    *
    * @param Illuminate\Http\Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function applyWork($work_id, $user_id)
    {

        $work = Work::find($work_id);

        $login_user = Auth::user();
        $post_user = User::find($user_id);

        if($work->user_id !== $login_user->id){

            if($this->existsApplyUsers($work, $login_user)){

                $login_user->appliedWorks()->detach($work->id);


            }else{

                $login_user->appliedWorks()->attach($work->id);

                // 案件投稿者への応募通知メール
                $post_user->sendApplicationNotification($login_user, $work);

            }
        }

        // return redirect()->route('message.show',['message_type' => 'direct', 'w' => $work->id, 'u' => $post_user->id]);
        return redirect()->route('works.show', $work->id);
    }

    /**
    * 案件いいね処理
    *
    * @param Illuminate\Http\Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function likeWork($work_id)
    {

        $work = Work::find($work_id);
        $login_user = Auth::user();
        $post_user = $work->postUser;

        if($work->user_id !== $login_user->id){

            if($this->existsLikeUsers($work, $login_user)){

                $login_user->likedWorks()->detach($work->id);

            }else{

                $login_user->likedWorks()->attach($work->id);

            }
        }

        return redirect()->route('works.show', $work->id);
    }

}
