/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import $ from 'jquery';
window.$ = $;
import Vue from 'vue';
import axios from 'axios';
window.axios = axios;
// import sanitizeHTML from 'sanitize-html';

// require('./bootstrap');
require('./assets/fix_footer');
require('./assets/works_new');
require('./assets/live_preview_img');
require('./assets/change_tab');
require('./assets/sp_nav_menu');
require('./assets/float_button');
require('./assets/flash_message');

Vue.prototype.axios = axios;
// Vue.prototype.sanitize = sanitizeHTML;
Vue.prototype.$ = $;






/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('work-item', require('./components/WorkItemComponent.vue').default);
Vue.component('message-list', require('./components/MessageListComponent.vue').default);
Vue.component('message-item', require('./components/MessageItemComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    methods: {
        // ユーザのプロフィール画像をgetする
        getImage: function (user) {
            var img = new Image()

            img.src = (user.thumbnail) ? user.thumbnail : '/images/default_user.jpg'

            return img.src;
        }
    }
});
