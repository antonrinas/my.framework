import Vue from 'vue';
import navigationBar from './components/navigation-bar.vue';
import router from './routes/routes';

const app = new Vue({
    data: {
        test: 'Это тест!'
    },
    components: {
        'navigation-bar': navigationBar,
    },
    mounted: function () {
    },
    computed: {
    }
}).$mount('#app');