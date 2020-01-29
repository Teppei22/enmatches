<template>
  <div class="c-chat">
    <div class="c-chat__list" ref="list">
      <section v-for="(works, index) in total_works" :key="index">
        <div class="c-chat__work-type">
          <template v-if="index==='posted'">投稿案件</template>
          <template v-else-if="index==='applied'">応募案件</template>
        </div>
        <section v-if="works.length === 0" class="c-chat__work--not-found">
          <template v-if="index==='posted'">登録された案件はありません</template>
          <template v-else-if="index==='applied'">応募した案件はありません</template>
        </section>
        <section v-for="work in works" :key="work.id" class="c-chat__work-wrapper">
          <section>
            <div class="c-chat__work__title">
              <a :href="'/works/'+work.id">
                {{ work.title }}
              </a>
            </div>

            <section class="c-chat__work-contents">
              <a class="c-chat__work__link" :href="'/message/public?w='+work.id">
                <div class="c-chat__msg-type" :class="{'c-chat__msg-type--msg-not-found': !work.public_latest_message}">
                  パブリックメッセージ
                </div>
                <div v-if="work.public_latest_message.length !== 0" class="c-chat__item">
                    <div class="c-badge--chat">
                      <div class="c-badge__content--chat">
                        <img :src="showImage(work.public_latest_message.from_user)" :class="'c-badge__img js-getImg'+work.public_latest_message.from_user_id">
                      </div>
                    </div>
                    <div class="c-chat__text">
                      <div class="c-chat__name">{{ work.public_latest_message.from_user_name }}</div>
                      <p class="c-chat__msg">
                        {{ work.public_latest_message.text }}
                      </p>
                    </div>
                    <div class="c-chat__date">
                      {{ work.public_latest_message.created_at }}
                    </div>

                </div>
              </a>
            </section>
            
          </section>

          <section>
            <div class="c-chat__msg-type">
              ダイレクトメッセージ
            </div>

            <div v-if="index==='posted' && work.apply_users.length === 0" class="c-chat__item--not-found">
              まだ応募者がいません
            </div>

            <template v-if="index === 'posted' && work.apply_users">
              <section v-for="user in work.apply_users" :key="user.id" class="c-chat__work-contents">
                <a :href="'/message/direct?w='+work.id+'&u='+user.id" class="c-chat__item">
                  <div class="c-badge--chat">
                    <div class="c-badge__content--chat">
                      <img :src="showImage(user)"  alt="" :class="'c-badge__img js-getImg'+user.id">
                    </div>
                  </div>
                  <div class="c-chat__text">
                    <div class="c-chat__name">{{ user.name }}</div>
                    <p v-if="user.direct_latest_message" class="c-chat__msg">
                      {{ user.direct_latest_message.text }}
                    </p>
                  </div>
                  <div class="c-chat__date" v-if="user.direct_latest_message">
                    {{ user.direct_latest_message.created_at }}
                  </div>
                </a>
              </section>
            </template>

              <template v-else-if="index === 'applied'">
                <section class="c-chat__work-contents">
                  <a :href="'/message/direct?w='+work.id+'&u='+work.user_id" class="c-chat__item">
                    <div class="c-badge--chat">
                      <div class="c-badge__content--chat">
                        <img :src="showImage(work.post_user)" :class="'c-badge__img js-getImg'+work.user_id">
                      </div>
                    </div>
                    <div class="c-chat__text">
                      <div class="c-chat__name">{{ work.post_user.name }}</div>
                      <p v-if="work.direct_latest_message" class="c-chat__msg">
                        {{ work.direct_latest_message.text }}
                      </p>
                    </div>
                    <div v-if="work.direct_latest_message"
                    class="c-chat__date">
                      {{ work.direct_latest_message.created_at }}
                    </div>
                  </a>
                </section>
              </template>

          </section>
        </section>

      </section>
      
    </div>
    
  </div>
</template>

<script>
  export default {
    props: ['self_user','posted_works','applied_works'],
    data: function(){
      return{
        partner_user_id: null,
        message_type: null,
        total_works: {
          "applied": this.$props.applied_works,
          "posted":  this.$props.posted_works
          
        },
        work: {}
      };
    },
    methods: {
      // ユーザのサムネイル画像を返す
      showImage: function(user){
        var img = new Image()

        img.src = (user.thumbnail) ? user.thumbnail : '/images/default_user.jpg'

        return img.src;
      }
    }
  }
</script>
