import Vue from 'vue';
import VueRouter from 'vue-router';
import tasksList from './../components/tasks-list.vue';
import chat from './../components/chat-box.vue';

Vue.use(VueRouter);

export default new VueRouter({
    routes:  [
        {path: '/', component: tasksList},
        {path: '/chat', component: chat},
    ],
    linkActiveClass: 'active'
});