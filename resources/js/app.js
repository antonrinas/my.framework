import Vue from 'vue';
import tasksList from './components/tasks-list.vue';
import navigationBar from './components/navigation-bar.vue';

const app = new Vue({
    data: {
        test: 'Это тест!'
    },
    components: {
        'tasks-list': tasksList,
        'navigation-bar': navigationBar,
    },
    mounted: function () {
    },
    computed: {
    }
}).$mount('#app');