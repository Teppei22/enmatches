<template>
  <div class="c-work-list__item">
    <a :href="'/works/'+work.id">
      <div class="c-work__content">
        <div class="c-work__title">
            {{ work['title'] }}
        </div>
        <span class="c-worktype">
          <span class="c-worktype__text">
            {{ getWorkType(work) }}
          </span>
        </span>
        <div class="c-work__price">
          <template v-if="getWorkType(work) === '単発案件'">
            {{ work.single_price_min }} ~ {{ work.single_price_max }}
          </template>
          <template v-else-if="getWorkType(work) === 'レベニューシェア'">
            {{ work.revenue_share_price }}
          </template>
        </div>
        <div class="c-work__status">
          <div class="c-work__status__apply-count">
            応募者数 <span>{{ apply_count }}</span> 人
          </div>

          <div class="c-work__status__date">
            {{ work.created_at }}
          </div>

          <template v-if="post_flg === 1">
            <div class="c-work__status__button">
              <a :href="'/works/'+work.id+'/edit'" class="c-btn c-btn--small c-btn--edit">
                編集
              </a>
            </div>
          </template>

          <template v-else>
            <div style="display:flex;line-height:30px;">
              {{ work.post_user.name }}
              <div class="c-badge--msg">
                <div class="c-badge__content--msg">
                  <a :href="'/user/'+work.user_id">
                    <img :src="showImage(work.post_user)"  alt="" :class="'c-badge__img js-getImg'+work.user_id">
                  </a>
                </div>
              </div>
            </div>
          </template>

        </div>
      </div>
    </a>
  </div>
</template>

<script>
    export default {
      // post_flg: 1(投稿者), 0それ以外
      props: ['work','apply_count','post_flg'],
      data: function(){
        return{

        };
      },
      methods: {
        // 案件の種類を返す
        getWorkType: function(work){
          if(work.type_id === 1){
            return "単発案件"
          }else if(work.type_id === 2){
            return "レベニューシェア"
          }
        },
        // サムネイル画像を表示する
        showImage: function(user){
          var img = new Image()

          img.src = (user.thumbnail) ? user.thumbnail : '/images/default_user.jpg'

          return img.src;
        }
      }
    }
</script>
