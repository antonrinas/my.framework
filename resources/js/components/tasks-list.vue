<template>
    <div id="tasks_list">
        <h2>Добро пожаловать</h2>
        <b-table
            :no-local-sorting="true"
            striped
            fixed
            hover
            :items="items"
            :fields="fields"
            :sort-by.sync="filters.sortBy"
            :sort-desc.sync="filters.sortDesc"
            v-on:sort-changed="changeSorting"
        ></b-table>

        <b-button-group size="sm">
            <b-button v-on:click="showEditModal" variant="success">Добавить</b-button>
            <b-button v-on:click="retrieveTasks" variant="info">Обновить</b-button>
        </b-button-group>

        <b-modal ref="myModal" v-bind:title="message.title" hide-footer>
            <div class="modal-body">
                <p>{{ message.content }}</p>
            </div>
            <div class="modal-footer">
                <b-button v-on:click="hideModal" variant="outline-danger">Закрыть</b-button>
            </div>
        </b-modal>

        <b-modal ref="editModal" title="Задача" hide-footer>
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
                    <b-button type="submit" variant="outline-success">Сохранить</b-button>
                </b-form>
            </div>
        </b-modal>
    </div>
</template>

<script>

    import bTable from 'bootstrap-vue/es/components/table/table';
    import bModal from 'bootstrap-vue/es/components/modal/modal';
    import bButton from 'bootstrap-vue/es/components/button/button';
    import bButtonGroup from 'bootstrap-vue/es/components/button-group/button-group';
    import bForm from 'bootstrap-vue/es/components/form/form';
    import bFormGroup from 'bootstrap-vue/es/components/form-group/form-group';
    import bFormInput from 'bootstrap-vue/es/components/form-input/form-input';
    import bFormTextarea from 'bootstrap-vue/es/components/form-textarea/form-textarea';
    import bFormFile from 'bootstrap-vue/es/components/form-file/form-file';

    export default {
        components: {
            'b-table': bTable,
            'b-modal': bModal,
            'b-button': bButton,
            'b-button-group': bButtonGroup,
            'b-form': bForm,
            'b-form-group': bFormGroup,
            'b-form-input': bFormInput,
            'b-form-textarea': bFormTextarea,
            'b-form-file': bFormFile,
        },
        data(){
            return {
                filters: {
                    sortBy: 'user_name',
                    sortDesc: false,
                    page: 1,
                },
                formData: {
                    user_name: null,
                    email: null,
                    description: null,
                    image: null,
                },
                formErrors: {
                    user_name: null,
                    email: null,
                    description: null,
                    image: null,
                },
                message: {
                    title: null,
                    content: null,
                },
                fields: [
                    {
                        key: 'user_name',
                        sortable: true,
                        label: 'Имя пользователя',
                    },
                    {
                        key: 'email',
                        sortable: true,
                        label: 'E-mail',
                    },
                    {
                        key: 'description',
                        sortable: true,
                        label: 'Задача',
                    },
                    {
                        key: 'image',
                        sortable: false,
                        label: 'Изображение',
                    },
                    {
                        key: 'status',
                        sortable: true,
                        label: 'Статус выполненения',
                    },
                ],
                items: [],
                uploadPercentCompleted: null,
            }
        },
        mounted: function () {
            this.retrieveTasks();
        },
        methods: {
            changeSorting: function(ctx){
                this.filters.sortBy = ctx.sortBy;
                this.filters.sortDesc = ctx.sortDesc;
                this.retrieveTasks();
            },
            retrieveTasks: function (){
                var vueInstance = this;
                axios.get('/api/tasks', {
                    params: {
                        sortBy: vueInstance.filters.sortBy,
                        sortDesc: vueInstance.filters.sortDesc ? 'DESC' : 'ASC',
                        page: vueInstance.filters.page,
                    }
                }).then(function (response) {
                    if (response.status === 200){
                        vueInstance.items = response.data.data;
                    } else {
                        vueInstance.makeMessage('Ошибка', response.data.message);
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            showModal: function() {
                this.$refs.myModal.show();
            },
            showEditModal: function() {
                this.$refs.editModal.show();
            },
            hideModal: function() {
                this.$refs.myModal.hide();
            },
            hideEditModal: function() {
                this.$refs.editModal.hide();
            },
            saveFormData: function() {
                var vueInstance = this;
                var data = new FormData();
                data.append('user_name', this.formData.user_name);
                data.append('email', this.formData.email);
                data.append('description', this.formData.description);
                data.append('image', this.formData.image);

                axios.post('/api/tasks', data, {
                    onUploadProgress: function(progressEvent) {
                        vueInstance.uploadPercentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    }
                }).then(function (response) {
                    if (response.status === 201){
                        if (response.data.status === 'warning'){
                            vueInstance.formErrors = response.data.messages;
                        } else {
                            vueInstance.hideEditModal();
                            vueInstance.retrieveTasks();
                        }
                    } else {
                        vueInstance.makeMessage('Ошибка', response.data.message);
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            resetForm: function() {

            },
            makeMessage: function(title, message) {
                vueInstance.message.title = title;
                vueInstance.message.content = message;
                vueInstance.showModal();
            }
        },
    }
</script>

<style scoped>
    h2 {
        color: green;
    }
    .error_message {
        color: red;
    }
</style>