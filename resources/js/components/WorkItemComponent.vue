<template>
    <div class="c-work-list__item">
      <div class="c-work__content">
        <div class="c-work__title">
          {{ work['title'] }}
        </div>
        <div class="c-work__type">
          {{ work_type }}
        </div>
        <div class="c-work__price">
          <!-- {{ work.type_id }}
          {{ work_types }} -->
          <template v-if="work_type === '個人開発'">
            {{ work.single_price_min }} ~ {{ work.single_price_max }}
          </template>
          <template v-else-if="work_type === 'レベニューシェア'">
            {{ work.revenue_share_price }}
          </template>
        </div>
        <div class="c-work__status">
          <div>
            <span>提案数:{{  }}
            </span>
          </div>
          <div>
            {{ user.name }}
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
      props: ['work','work_type','user'],
      data: function(){
        return{
        };
      }
    }
</script>
