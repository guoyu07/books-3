// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
require('./../node_modules/purecss/build/base-min.css');
require('./../node_modules/purecss/build/grids-min.css');
require('./../node_modules/purecss/build/grids-responsive-min.css');

import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import App from './App'

Vue.use(VueResource);
Vue.use(VueRouter);

const router = new VueRouter({
    mode   : 'history',
    routes : [
        {
            path : '/',
            name : 'home',
            component : require('./home/home.vue'),
        },
        {
            path : '/book/:book_id/chap',
            name:'chapter',
            component : require('./chapter/chapter.vue'),
        },
        {
            path : '/book/:book_id',
            name:'reader',
            component : require('./reader/reader.vue'),
        }
    ]
});

Vue.component('icon', require('./_components/icon.vue'));

new Vue({
    el     : '#app',
    render : h => h(App),
    router : router
});
