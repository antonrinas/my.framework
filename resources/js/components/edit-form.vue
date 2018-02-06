<template>
    <div id="edit_form">
        <b-modal ref="editModal" title="Задача" hide-footer v-on:hide="hideModal">
            <div class="modal-body">
                <b-form v-on:submit.prevent="saveFormData" v-on:reset="resetForm">
                    <b-form-group label="Имя пользователя*:" label-for="user_name">
                        <b-form-input id="user_name"
                                      v-bind:class="{'is-invalid': formErrors.user_name}"
                                      type="text"
                                      v-model="formData.user_name"
                                      required
                                      placeholder="Введите имя пользователя"
                                      v-on:input="formErrors.user_name = null"
                        ></b-form-input>
                        <div v-if="formErrors.user_name" class="error_message">
                            {{ formErrors.user_name }}
                        </div>
                    </b-form-group>
                    <b-form-group label="E-mail*:" label-for="email">
                        <b-form-input id="email"
                                      v-bind:class="{'is-invalid': formErrors.email}"
                                      type="email"
                                      v-model="formData.email"
                                      required
                                      placeholder="Введите E-mail"
                                      v-on:input="formErrors.email = null"
                        ></b-form-input>
                        <div v-if="formErrors.email" class="error_message">
                            {{ formErrors.email }}
                        </div>
                    </b-form-group>
                    <b-form-group label="Задача*:" label-for="description">
                        <b-form-textarea id="description"
                                         v-bind:class="{'is-invalid': formErrors.description}"
                                         v-model="formData.description"
                                         placeholder="Опишите задачу"
                                         :rows="3"
                                         :max-rows="6"
                                         v-on:input="formErrors.description = null"
                        ></b-form-textarea>
                        <div v-if="formErrors.description" class="error_message">
                            {{ formErrors.description }}
                        </div>
                    </b-form-group>
                    <b-form-group label="Изображение:" label-for="image">
                        <b-form-file
                                id="image"
                                :state="formErrors.image ? 'invalid' : null"
                                accept="image/jpeg, image/png, image/gif"
                                v-model="formData.image"
                                placeholder="Файл не указан"
                                choose-label="Выберите файл"
                                v-on:input="formErrors.image = null"
                        ></b-form-file>
                        <div v-if="formErrors.image" class="error_message">
                            {{ formErrors.image }}
                        </div>
                    </b-form-group>

                    <b-form-group label="" label-for="">
                        <b-form-checkbox
                                v-if="editAvailable"
                                v-bind:value="'2'"
                                v-bind:unchecked-value="'1'"
                                v-model="formData.status"
                        >{{ formData.status === '2' ? 'Выполнено' : 'Не выполнено' }}</b-form-checkbox>
                    </b-form-group>

                    <b-button type="submit" variant="outline-success">Сохранить</b-button>
                </b-form>
            </div>
        </b-modal>

        <messanger
                v-bind:show-message="showMessage"
                v-bind:title="message.title"
                v-bind:content="message.content"
                v-on:hide="showMessage = false"
        ></messanger>
    </div>
</template>

<script>

    import bModal from 'bootstrap-vue/es/components/modal/modal';
    import bButton from 'bootstrap-vue/es/components/button/button';
    import bForm from 'bootstrap-vue/es/components/form/form';
    import bFormGroup from 'bootstrap-vue/es/components/form-group/form-group';
    import bFormInput from 'bootstrap-vue/es/components/form-input/form-input';
    import bFormTextarea from 'bootstrap-vue/es/components/form-textarea/form-textarea';
    import bFormFile from 'bootstrap-vue/es/components/form-file/form-file';
    import bFormCheckbox from 'bootstrap-vue/es/components/form-checkbox/form-checkbox';
    import messanger from './messanger.vue';

    export default {
        props: ['showForm', 'taskId', 'editAvailable'],
        components: {
            'b-modal': bModal,
            'b-button': bButton,
            'b-form': bForm,
            'b-form-group': bFormGroup,
            'b-form-input': bFormInput,
            'b-form-textarea': bFormTextarea,
            'b-form-file': bFormFile,
            'b-form-checkbox': bFormCheckbox,
            'messanger': messanger,
        },
        data(){
            return {
                formData: {
                    user_name: null,
                    email: null,
                    description: null,
                    image: null,
                    status: '1',
                },
                formErrors: {
                    user_name: null,
                    email: null,
                    description: null,
                    image: null,
                    status: '1',
                },
                uploadPercentCompleted: null,
                showMessage: false,
                message: {
                    title: null,
                    content: null,
                },
            }
        },
        watch: {
            showForm: function (value) {
                if (value === true){
                    this.showEditModal();
                } else {
                    this.$refs.editModal.hide();
                }
            },
        },
        methods: {
            showEditModal: function() {
                this.resetForm();
                if (this.taskId){
                    this.retrieveTask();
                } else {
                    this.$refs.editModal.show();
                }
            },
            hideModal: function() {
                this.$emit('hide', true);
            },
            saveFormData: function() {
                var data = new FormData();
                data.append('user_name', this.formData.user_name);
                data.append('email', this.formData.email);
                data.append('description', this.formData.description);
                data.append('image', this.formData.image);
                data.append('status', this.formData.status);

                if (this.taskId){
                    this.updateTask(data);
                } else {
                    this.addTask(data);
                }


            },
            addTask: function (data) {
                var vueInstance = this;
                axios.post('/api/tasks', data, {
                    onUploadProgress: function(progressEvent) {
                        vueInstance.uploadPercentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    }
                }).then(function (response) {
                    if (response.status === 201 || response.status === 200){
                        if (response.data.status === 'warning'){
                            for (var propertyName in vueInstance.formErrors){
                                if (response.data.messages.hasOwnProperty(propertyName)) {
                                    vueInstance.formErrors[propertyName] = response.data.messages[propertyName];
                                }
                            }
                        } else {
                            vueInstance.hideModal();
                            vueInstance.$emit('added', true);
                        }
                    } else {
                        vueInstance.makeMessage('Ошибка', response.data.message);
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            updateTask: function(data) {
                var vueInstance = this;
                axios.post('/api/tasks/' + this.taskId, data, {
                    onUploadProgress: function(progressEvent) {
                        vueInstance.uploadPercentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    }
                }).then(function (response) {
                    if (response.status === 200){
                        if (response.data.status === 'warning'){
                            for (var propertyName in vueInstance.formErrors){
                                if (response.data.messages.hasOwnProperty(propertyName)) {
                                    vueInstance.formErrors[propertyName] = response.data.messages[propertyName];
                                }
                            }
                        } else {
                            vueInstance.hideModal();
                            vueInstance.$emit('updated', true);
                        }
                    } else {
                        vueInstance.makeMessage('Ошибка', response.data.message);
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            retrieveTask: function() {
                var vueInstance = this;
                axios.get('/api/tasks/' + vueInstance.taskId + '/edit' , {}).then(function (response) {
                    if (response.status === 200){
                        vueInstance.formData.user_name = response.data.data.user_name;
                        vueInstance.formData.email = response.data.data.email;
                        vueInstance.formData.description = response.data.data.description;
                        vueInstance.formData.status = response.data.data.status;
                        vueInstance.$refs.editModal.show();
                    } else {
                        vueInstance.makeMessage('Ошибка', response.data.message);
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            resetForm: function() {
                this.formData = {
                    user_name: null,
                    email: null,
                    description: null,
                    image: null,
                    status: '1',
                };
                this.formErrors = {
                    user_name: null,
                    email: null,
                    description: null,
                    image: null,
                    status: '1',
                };
            },
            makeMessage: function(title, message) {
                this.message.title = title;
                this.message.content = message;
                this.showMessage = true;
            },
        },
    }
</script>

<style scoped>
    .error_message {
        color: red;
    }
</style>