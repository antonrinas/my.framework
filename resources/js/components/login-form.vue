<template>
    <div id="login_form">
        <b-modal ref="loginModal" title="Вход в систему" hide-footer v-on:hide="hideLoginModal">
            <div class="modal-body">
                <b-form v-on:submit.prevent="saveFormData" v-on:reset="resetForm">
                    <b-form-group label="Логин*:" label-for="email">
                        <b-form-input id="login_email"
                                      v-bind:class="{'is-invalid': formErrors.email}"
                                      type="text"
                                      v-model="formData.email"
                                      required
                                      placeholder="Введите логин"
                                      v-on:input="formErrors.email = null"
                        ></b-form-input>
                        <div v-if="formErrors.email" class="error_message">
                            {{ formErrors.email }}
                        </div>
                    </b-form-group>
                    <b-form-group label="Пароль*:" label-for="password">
                        <b-form-input id="login_password"
                                      v-bind:class="{'is-invalid': formErrors.password}"
                                      type="password"
                                      v-model="formData.password"
                                      required
                                      placeholder="Введите пароль"
                                      v-on:input="formErrors.password = null"
                        ></b-form-input>
                        <div v-if="formErrors.password" class="error_message">
                            {{ formErrors.password }}
                        </div>
                    </b-form-group>
                    <div v-if="generalError" class="error_message general_message">
                        {{ generalError }}
                    </div>
                    <b-button type="submit" variant="outline-success">Войти</b-button>
                </b-form>
            </div>
        </b-modal>
    </div>
</template>

<script>

    import bModal from 'bootstrap-vue/es/components/modal/modal';
    import bButton from 'bootstrap-vue/es/components/button/button';
    import bForm from 'bootstrap-vue/es/components/form/form';
    import bFormGroup from 'bootstrap-vue/es/components/form-group/form-group';
    import bFormInput from 'bootstrap-vue/es/components/form-input/form-input';

    export default {
        props: ['showLoginForm'],
        components: {
            'b-modal': bModal,
            'b-button': bButton,
            'b-form': bForm,
            'b-form-group': bFormGroup,
            'b-form-input': bFormInput,
        },
        data(){
            return {
                formData: {
                    email: null,
                    password: null,
                },
                formErrors: {
                    email: null,
                    password: null,
                },
                generalError: null,
            }
        },
        watch: {
            showLoginForm: function (value) {
                if (value === true){
                    this.showLoginModal();
                } else {
                    this.$refs.loginModal.hide();
                }
            },
        },
        methods: {
            showLoginModal: function() {
                this.resetForm();
                this.$refs.loginModal.show();
            },
            hideLoginModal: function() {
                this.$emit('hide', true);
            },
            saveFormData: function() {
                var vueInstance = this;
                var data = new FormData();
                data.append('email', this.formData.email);
                data.append('password', this.formData.password);

                axios.post('/api/login', data).then(function (response) {
                    if (response.status === 201 || response.status === 200){
                        if (response.data.status === 'warning'){
                            for (var propertyName in vueInstance.formErrors){
                                if (response.data.messages.hasOwnProperty(propertyName)) {
                                    vueInstance.formErrors[propertyName] = response.data.messages[propertyName];
                                }
                            }
                            vueInstance.generalError = response.data.general_message;
                        } else {
                            vueInstance.$emit('success-login', true);
                        }
                    } else {
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            resetForm: function() {
                this.formData = {
                    email: null,
                    password: null,
                };
                this.formErrors = {
                    email: null,
                    password: null,
                };
            },
        },
    }
</script>

<style scoped>
    .error_message {
        color: red;
    }
    .general_message {
        margin-bottom: 10px;
    }
</style>