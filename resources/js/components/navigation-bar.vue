<template>
    <div id="navigation_bar">
        <b-navbar toggleable="md" type="light" variant="faded">
            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
            <b-navbar-brand href="/">Главная</b-navbar-brand>

            <b-collapse is-nav id="nav_collapse">
                <b-navbar-nav class="ml-auto">
                    <template v-if="authenticated === 0">
                        <b-nav-item href="#" v-on:click="showLoginForm = true">Войти</b-nav-item>
                    </template>
                    <template v-else>
                        <b-nav-item href="#" disabled>Здравствуйте, Администратор!</b-nav-item>
                        <b-nav-item href="#" v-on:click="logout">Выйти</b-nav-item>
                    </template>
                </b-navbar-nav>
            </b-collapse>

            <login-form
                    v-bind:show-login-form="showLoginForm"
                    v-on:hide="showLoginForm = false"
                    v-on:success-login="successHandler"
            ></login-form>
        </b-navbar>

    </div>
</template>

<script>
    import loginForm from './login-form.vue';
    import bNavbar from 'bootstrap-vue/es/components/navbar/navbar';
    import bNavbarToggle from 'bootstrap-vue/es/components/navbar/navbar-toggle';
    import bCollapse from 'bootstrap-vue/es/components/collapse/collapse';
    import bNavbarNav from 'bootstrap-vue/es/components/navbar/navbar-nav';
    import bNavItem from 'bootstrap-vue/es/components/nav/nav-item';
    import bNavbarBrand from 'bootstrap-vue/es/components/navbar/navbar-brand';

    export default {
        props: ['authenticated'],
        components: {
            'b-navbar': bNavbar,
            'b-navbar-toggle': bNavbarToggle,
            'b-collapse': bCollapse,
            'b-navbar-nav': bNavbarNav,
            'b-nav-item': bNavItem,
            'b-navbar-brand': bNavbarBrand,
            'login-form': loginForm,
        },
        data(){
            return {
                showLoginForm: false,
            }
        },
        mounted: function () {
        },
        methods: {
            successHandler: function() {
                window.location.reload();
            },
            logout: function() {
                var vueInstance = this;

                axios.post('/api/logout', {}).then(function (response) {
                    if (response.status === 201){
                        window.location.reload();
                    } else {
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
    }
</script>

<style scoped>

</style>