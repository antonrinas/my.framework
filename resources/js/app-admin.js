import 'bootstrap';
import Vue from 'vue';
import store from './stores/main-store';
import router from './routes/routes';

import appLayout from './components/layout/app-layout.vue';
import headerGuest from './components/layout/header-guest.vue';
import headerUser from './components/layout/header-user.vue';
import footerGuest from './components/layout/footer-guest.vue';
import footerUser from './components/layout/footer-user.vue';

const app = new Vue({
    store, // сокращение от `store: store`
    router, // сокращение от `router: router`
    components: {
        'app-layout': appLayout,
        'header-guest': headerGuest,
        'header-user': headerUser,
        'footer-guest': footerGuest,
        'footer-user': footerUser,
    },
    mounted: function () {
        if (window.localStorage.getItem('access_token')){
            this.$store.commit('setAuthenticated');
        }
    },
    computed: {
        isAuthenticated: function () {
            return this.$store.state.isAuthenticated;
        }
    }
}).$mount('#app');