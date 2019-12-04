<template>
    <div class="c-work-list">
      <work-item v-for="work in works"
        v-bind:key="work.id"
        v-bind:work="work"
        v-bind:user="user(work.user_id)"
        v-bind:work_type="showWorkType(work.type_id)"
        >
      </work-item>
    </div>
</template>

<script>
    export default {
      props: ['works','work_types','users'],
      data: function(){
        return{
        };
      },
      methods: {
        showWorkType(type_id){
          // 案件種類を返す
          var t_id = type_id - 1;
          return this.work_types[t_id].name;
        },
        user(user_id){
          // workに対応するユーザを返す
          return this.users.find(element => element.id === user_id);
        }
      }
    }
</script>
