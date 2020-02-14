<template>
    <div class="c-message">
      <div class="c-message__list" ref="list">

        <template v-if="messages.length === 0">
          <template v-if="message_type === 'direct'">

            <section class="c-message__item--none" v-if="work.user_id == self_user_id">
              メッセージであなたの要望を伝えましょう!
            </section>
            <section class="c-message__item--none" v-else>
              メッセージであなたを<br>アピールしましょう!
            </section>

          </template>

          <template v-else-if="message_type === 'public'">
            <section class="c-message__item--none">
              パブリックメッセージはまだありません
            </section>
          </template>

        </template>

        
        
        <template v-for="msg in messages">

          <section v-if="checkRLMsg(msg)===rl_flg['right']" v-bind:key="msg.id"
          class="c-message__item c-message__item--msg-right" >
            <div class="c-badge--msg">
              <div class="c-badge__content--msg">
                <a :href="'/user/'+msg.from_user_id">
                  <img :src="showImage(msg.from_user)"  alt="" :class="'c-badge__img js-getImg'+msg.from_user_id">
                </a>
              </div>
            </div>
            <div class="c-message__body">
              <span class="c-message__name --msg-right">{{ msg.from_user_name }}</span>
              <p class="c-message__text">{{ msg.text }}</p>
              
            </div>
            <div class="c-message__date">{{ getTime(msg) }}</div>
            
            
          </section>

          <section v-else v-bind:key="msg.id"
          class="c-message__item c-message__item--msg-left">
            <div class="c-badge--msg">
              <div class="c-badge__content--msg">
                <a :href="'/user/'+msg.from_user_id">
                  <img :src="showImage(msg.from_user)"  alt="" :class="'c-badge__img js-getImg'+msg.from_user_id">
                </a>
              </div>
              
            </div>
            <div class="c-message__body">
              <span class="c-message__name --msg-left">{{ msg.from_user_name }}</span>
              <p class="c-message__text">{{ msg.text }}</p>
            </div>
            <div class="c-message__date">{{ getTime(msg) }}</div>
          </section>
          

        </template>

      </div>
      
      <form v-if="self_user_id" class="c-message__form" v-on:submit.prevent>
        <div class="c-message__input">

          {{ countMessage }} / {{ this.max_str_length }}
          <span v-if="countMessage > this.max_str_length" style="color: red">文字数が超過しています。</span>
          

          <textarea v-model="new_message" class="c-message__input-textarea" placeholder="丁寧なコメントを心がけましょう">
          </textarea>
        </div>
        <div class="c-message__btn">
          <button @click="addMsg" class="c-btn c-btn--medium c-btn--comment">
            コメント
          </button>
        </div>
        
      </form>
    </div>
</template>

<script>
  export default {
    props: ['self_user_id','partner_user_id','message_type','work'],
    data: function(){
      return{
        new_message: "",
        rl_flg: {
          // メッセージの右左フラグ
          'right': true,
          'left': false
        },
        users:{},
        messages: [],
        max_str_length: 200
      };
    },
    mounted(){
      this.fetchMsgs()
      this.setScrollToEnd();
    },
    watch: {
      messages: function(){
        this.setScrollToEnd();
      }
    },
    computed: {
      countMessage: function(){
        return this.new_message.replace(/(\n|\r)/g, "").length;
      }
    },
    methods: {
      // 対応メッセージを持ってくる
      fetchMsgs: function () {
        var self = this;
        if(this.$props.message_type === 'public'){
          axios.get('/ajax/messages', {
            params:{
              message_type_key: 'public',
              work_id: this.$props.work.id
            }
          }).then(function(res) {
            self.messages = res.data; //←取得したMessageリストをmessagesに格納

          })
        }else if(this.$props.message_type === 'direct'){
          axios.get('/ajax/messages', {
            params:{
              message_type_key: 'direct',
              work_id: this.$props.work.id,
              partner_id: this.$props.partner_user_id
            }
          }).then(function(res){
            self.messages = res.data; //←取得したMessageリストをmessagesに格納
          })
        }
        
      },
      // メッセージを右・左に設置するか判断
      checkRLMsg: function(msg){
        // メッセージが右側か左側か判断

        if(this.$props.message_type === 'direct'){
          // ダイレクトメッセージの場合

          if(msg.from_user_id === this.$props.self_user_id){
            // メッセージ送信者が自分だった場合
            return this.rl_flg['right'];
          }else{
            return this.rl_flg['left'];
          }
        }

        if(this.$props.message_type === 'public' && this.$props.self_user_id === this.work.user_id){
          // パブリックメッセージで自分が投稿案件者の場合

          if(msg.from_user_id === this.work.user_id){
            // メッセージ送信者が案件投稿者だった場合
            return this.rl_flg['right'];
          }else{
            return this.rl_flg['left'];
          }
        }else if(this.$props.message_type === 'public' && this.$props.self_user_id !== this.work.user_id){
          // パブリックメッセージで自分が投稿案件者以外の場合

          if(msg.from_user_id === this.work.user_id){
            // メッセージ送信者が案件投稿者だった場合
            return this.rl_flg['left'];
          }else{
            return this.rl_flg['right'];
          }
        }
      },
      // メッセージのスクロールを最下に移動
      setScrollToEnd: function(){
        $(function(){
          var $target = $('.c-message__list');
          
          $target.animate({scrollTop: $target[0].scrollHeight});
        })
        
      },
      // メッセージを保存
      addMsg: function(){
        // this.new_message = this.new_message.replace(/(\n|\r)/g, "");

        if (!this.new_message || this.self_user_id === null) {
          return;
        }
        if(this.countMessage > this.max_str_length){
          return;
        }

        var self = this;
        axios.post('/ajax/messages', {
          work_id: this.$props.work.id,
          message_type_key: this.$props.message_type,
          text: this.new_message,
          from_user_id: this.$props.self_user_id,
          to_user_id: (this.$props.message_type === 'direct') ? this.$props.partner_user_id : null
        })
        .then(function(res) {
          self.messages = res.data;
          self.new_message = '';
        })
        
      },
      // messageのcreated_atの日時を表示
      getTime: function(msg){
        var day_time = msg.created_at.slice(5,-3);
        return day_time;
      },
      // ユーザのプロフィール画像を表示する
      showImage: function(user){
        var img = new Image();

        img.src = (user.thumbnail) ? user.thumbnail : '/images/default_user.jpg';

        return img.src;
      }
    }
  }
</script>
