import Vue from 'vue';
import tasksList from './components/tasks-list.vue';

const app = new Vue({
    data: {
        test: 'Это тест!'
    },
    components: {
        'tasks-list': tasksList
    },
    mounted: function () {
    },
    computed: {
    }
}).$mount('#app');