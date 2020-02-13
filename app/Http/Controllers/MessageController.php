<?php

namespace App\Http\Controllers;

use App\User;
use App\Work;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WorksController;

/**
 * メッセージのビュー表示・メッセージ送信等のajax処理
 * 
 */
class MessageController extends Controller
{

    public $message_type =[
        "public" => 1,
        "direct" =>2
    ];

    /**
     * メッセージビュー作成
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $self_user = Auth::user();

        $posted_works = $self_user->postedWorks;
        $applied_works = $self_user->appliedWorks;

        [
            "posted_works" =>$posted_works,
            "applied_works" =>$applied_works,
        ] = $this->getLatestMsgWorks($posted_works, $applied_works);

        return view('message.index',compact('posted_works','applied_works'));
    }

    /**
     * 指定メッセージの詳細ページ表示
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $message_type
     * @param  int  $id
     * @return 
     */
    public function show(Request $request, $message_type)
    {
        $request->message_type = $message_type;
        $request->validate([
            'message_type' => 'regex:/^(direct|public)$/',
            'w' => 'required|integer',
            'u' => ['required_if:message_type,direct|integer'],
        ]);

        $worksController = new WorksController;
        $work_id = $request->w;
        $work = Work::find($work_id);
        $login_user = Auth::user();
        $partner_user = ($message_type == 'direct') ? User::find($request->u) : null;

        if(
            // 案件が存在するか
            empty($work) || 

            // メッセージでpartnerと自分が案件の投稿者か応募者の関係になってるか
            (
                !(
                    $message_type == 'direct' &&
                    (
                        ( ($work->user_id == $login_user->id) && $worksController->existsApplyUsers($work, $partner_user) ) || 
                        ( ($work->user_id == $partner_user->id) && $worksController->existsApplyUsers($work, $login_user) )
                    )
                ) &&
                !(
                    $message_type == 'public' && ( $work->user_id == $login_user->id || $worksController->existsApplyUsers($work, $login_user) )
                )
            )
        ){
            abort('404');
        }
        
        return view('message.show', compact('work','partner_user','message_type'));
    }

    /**
     * ajax(vue:axios)関連
     * 特定相手とのダイレクトメッセージ・特定案件のパブリックメッセージを取得
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return App\Message $msgs
     */
    public function index(Request $request)
    {
        $self_id = Auth::id();
        $work_id = $request->work_id;
        $message_type = $this->message_type[$request->message_type_key];

        $partner_id = $request->partner_id;
        
        $msgs = $this->getMessages($work_id,$message_type,$self_id,$partner_id);

        return $msgs;
    }

    /**
     * ajax(vue:axios)関連
     * 新規メッセージを入力し、コメントボタンを押した後の保存処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return 
     */
    public function store(Request $request)
    {
        $msg = new Message;
        $message_type = $this->message_type[$request->message_type_key];

        $msg->message_type = $message_type;
        $msg->fill($request->all())->save();
        

        $work_id = $request->work_id;
        $self_id = Auth::id();
        $partner_id = $request->to_user_id;

        $msgs = $this->getMessages($work_id,$message_type,$self_id,$partner_id);
        return $msgs;

    }

    /**
     * メッセージ送信者のユーザを取得する
     *
     * @param int $work_id
     * @param int $message_type
     * @param int $self_id
     * @param int $partner_id
     * 
     * @return App\User
     */
    public function getfromUser($msg){
        return $msg->fromUser;
    }

    /**
     * 自分とパートナーが連絡した最新メッセージを取得する
     *
     * @param array App\Message $messages
     * 
     * @return App\Message
     */
    public function getLatestMessage($work_id, $message_type, $self_id, $partner_id)
    {
        if($message_type === $this->message_type['public']){
            // パブリックメッセージの場合
            $msg= Message::where('work_id',$work_id)
                        ->where('message_type',$this->message_type['public'])
                        ->latest()->first();
        }else if($message_type === $this->message_type['direct'] && $partner_id){
            // ダイレクトメッセージの場合

            if($partner_id == null){
                $partner_id = "any";
            }

            $msg= Message::where('work_id',$work_id)
                            ->where('message_type',$this->message_type['direct'])
                            ->where(function($query)use($self_id,$partner_id){
                                return $query->where(function($query)use($self_id,$partner_id){
                                                        return $query->where('from_user_id',$self_id)
                                                                    ->where('to_user_id',$partner_id);
                                                    })
                                            ->orWhere(function($query)use($self_id,$partner_id){
                                                        return $query->where('from_user_id',$partner_id)
                                                                    ->where('to_user_id',$self_id);
                                                    });
                                })->latest()->first();
        }

        if(empty($msg))return;
        $msg->from_user_name = $this->getfromUser($msg)->name;
        
        return $msg;
    }

    /**
     * ある案件において自分とパートナーが連絡したメッセージを取得する
     *
     * @param int $work_id
     * @param int $message_type
     * @param int $self_id
     * @param int $partner_id
     * 
     * @return 
     */
    public function getMessages($work_id, $message_type, $self_id, $partner_id)
    {
        if($message_type === $this->message_type['public']){
            // パブリックメッセージの場合
            $msgs= Message::where('work_id',$work_id)
                        ->where('message_type',$this->message_type['public'])
                        ->get();
        }else if($message_type === $this->message_type['direct'] && $partner_id){
            // ダイレクトメッセージの場合

            if($partner_id == null){
                $partner_id = "any";
            }

            $msgs= Message::where('work_id',$work_id)
                            ->where('message_type',$this->message_type['direct'])
                            ->where(function($query)use($self_id,$partner_id){
                                return $query->where(function($query)use($self_id,$partner_id){
                                                        return $query->where('from_user_id',$self_id)
                                                                    ->where('to_user_id',$partner_id);
                                                    })
                                            ->orWhere(function($query)use($self_id,$partner_id){
                                                        return $query->where('from_user_id',$partner_id)
                                                                    ->where('to_user_id',$self_id);
                                                    });
                                })->get();
        }

        foreach ($msgs as $msg) {
            $msg->from_user_name = $this->getfromUser($msg)->name;

        }
        
        return $msgs;
    }

    /**
     * 自分の登録・応募案件に関連する最新メッセージを取得しWorkに設置する
     *
     * @param App\Work $posted_works ログインユーザの登録案件
     * @param App\Work $applied_works ログインユーザの応募案件
     * 
     * @return 
     */
    public function getLatestMsgWorks($posted_works, $applied_works)
    {

        foreach ($posted_works as $work) {
            $work->apply_users = $work->applyUsers;

            foreach ($work->apply_users as $partner_user) {
                $direct_lastMsg = $this->getLatestMessage($work->id,$this->message_type['direct'],Auth::id(),$partner_user->id);

                $partner_user->direct_latest_message = $direct_lastMsg;
            }
            
            $public_lastMsg = $this->getLatestMessage($work->id,$this->message_type['public'],null,null);
            
            $work->public_latest_message = $public_lastMsg;
            
        }

        foreach ($applied_works as $work) {

            $partner_postuser = $work->postUser;
            $direct_lastMsg = $this->getLatestMessage($work->id,$this->message_type['direct'],Auth::id(),$partner_postuser->id);

            $work->direct_latest_message = $direct_lastMsg;
            
            $public_lastMsg = $this->getLatestMessage($work->id,$this->message_type['public'],null,null);

            $work->public_latest_message = $public_lastMsg;
            
        }

        return [
            "posted_works" =>$posted_works,
            "applied_works" =>$applied_works,
        ];
    }
}