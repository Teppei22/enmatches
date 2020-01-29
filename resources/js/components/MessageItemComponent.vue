<template>
    <div class="c-message">
      <div class="c-message__list" ref="list">
        <template v-if="message_type === 'direct' && messages.length === 0">
          <section class="c-message__item--none" v-if="work.user_id == self_user_id">
            メッセージであなたの要望を伝えましょう!
          </section>
          <section class="c-message__item--none" v-if="work.user_id !== self_user_id">
            メッセージであなたをアピールしましょう!
          </section>
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
            <div class="c-message__content">
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
            <div class="c-message__content">
              <span class="c-message__name --msg-left">{{ msg.from_user_name }}</span>
              <p class="c-message__text">{{ msg.text }}</p>
            </div>
            <div class="c-message__date">{{ getTime(msg) }}</div>
          </section>
          

        </template>

      </div>
      
      <form class="c-message__form" v-on:submit.prevent>
        <div class="c-message__input">
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
        messages: []
      };
    },
    mounted(){
      this.fetchMsgs()
      this.setScrollToEnd();
    },
    watch: {
      messages: function(){
        this.setScrollToEnd()
      }
    },
    methods: {
      // 対応メッセージを持ってくる
      fetchMsgs: function () {
        if(this.$props.message_type === 'public'){
          axios.get('/ajax/messages', {
            params:{
              message_type_key: 'public',
              work_id: this.$props.work.id
            }
          }).then((res) => {
            this.messages = res.data //←取得したMessageリストをmessagesに格納

          })
        }else if(this.$props.message_type === 'direct'){
          axios.get('/ajax/messages', {
            params:{
              message_type_key: 'direct',
              work_id: this.$props.work.id,
              partner_id: this.$props.partner_user_id
            }
          }).then((res) => {
            this.messages = res.data //←取得したMessageリストをmessagesに格納
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
        if (!this.new_message || this.self_user_id === null) {
          return
        }
        axios.post('/ajax/messages', {
          work_id: this.$props.work.id,
          message_type_key: this.$props.message_type,
          text: this.new_message,
          from_user_id: this.$props.self_user_id,
          to_user_id: (this.$props.message_type === 'direct') ? this.$props.partner_user_id : null
        })
        .then((res) => {
          this.messages = res.data
          this.new_message = ''
        })
        
      },
      // messageのcreated_atの日時を表示
      getTime: function(msg){
        var day_time = msg.created_at.slice(5,-3)
        return day_time
      },
      // ユーザのプロフィール画像を表示する
      showImage: function(user){
        var img = new Image()

        img.src = (user.thumbnail) ? user.thumbnail : '/images/default_user.jpg'

        return img.src;
      }
    }
  }
</script>
