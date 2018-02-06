<template>
    <div id="tasks_list">
        <b-table
            :no-local-sorting="true"
            striped
            hover
            responsive
            :items="items"
            :fields="fields"
            :sort-by.sync="filters.sortBy"
            :sort-desc.sync="filters.sortDesc"
            v-on:sort-changed="changeSorting"
            empty-text="Записи отсутствуют"
        >
            <template slot="user_name" slot-scope="data">
                {{ data.item.user_name }}
            </template>
            <template slot="email" slot-scope="data">
                {{ data.item.email }}
            </template>
            <template slot="description" slot-scope="data">
                {{ data.item.description }}
            </template>
            <template slot="path_thumb_1" slot-scope="data">
                <template v-if="data.item.path_thumb_1">
                    <a v-bind:href="data.item.path" target="_blank">
                        <img v-bind:src="data.item.path_thumb_1" alt="Изображение к задаче" style="width: 100%;" />
                    </a>
                </template>
                <template v-else>
                    отсутствует
                </template>
            </template>
            <template slot="status" slot-scope="data">
                <template v-if="data.item.status === '2'">
                    <b-form-checkbox
                        v-bind:disabled="true"
                        v-bind:checked="true"
                    >выполнено</b-form-checkbox>
                </template>
                <template v-else>
                    <b-form-checkbox
                        v-bind:disabled="true"
                        v-bind:checked="false"
                    >не выполнено</b-form-checkbox>

                </template>
            </template>

            <template v-if="editAvailable" slot="actions" slot-scope="data">
                <b-button v-on:click="editTask(data.item.id)" variant="warning">Редактировать</b-button>
            </template>

        </b-table>
        <p class="text-center" v-show="items.length === 0">Записи отсутствуют</p>

        <div class="row">
            <div class="col-sm-4">
                <b-button-group size="sm">
                    <b-button v-on:click="addTask" variant="success">Добавить</b-button>
                    <b-button v-on:click="retrieveTasks" variant="primary">Обновить</b-button>
                </b-button-group>
            </div>
            <div class="col-sm-8">
                <b-pagination
                    align="right"
                    :total-rows="totalRows"
                    v-model="filters.page"
                    :per-page="perPage"
                    v-on:input="retrieveTasks"
                ></b-pagination>
            </div>
        </div>

        <edit-form
                v-bind:show-form="showForm"
                v-bind:task-id="taskId"
                v-bind:edit-available="editAvailable"
                v-on:hide="showForm = false"
                v-on:added="retrieveTasks"
                v-on:updated="retrieveTasks"
        ></edit-form>

        <messanger
                v-bind:show-message="showMessage"
                v-bind:title="message.title"
                v-bind:content="message.content"
                v-on:hide="showMessage = false"
        ></messanger>
    </div>
</template>

<script>
    import editForm from './edit-form.vue';
    import messanger from './messanger.vue';
    import bTable from 'bootstrap-vue/es/components/table/table';
    import bButton from 'bootstrap-vue/es/components/button/button';
    import bButtonGroup from 'bootstrap-vue/es/components/button-group/button-group';
    import bPagination from 'bootstrap-vue/es/components/pagination/pagination';
    import bFormCheckbox from 'bootstrap-vue/es/components/form-checkbox/form-checkbox';

    export default {
        props: ['editAvailable'],
        components: {
            'b-table': bTable,
            'b-button': bButton,
            'b-button-group': bButtonGroup,
            'b-pagination': bPagination,
            'b-form-checkbox': bFormCheckbox,
            'edit-form': editForm,
            'messanger': messanger,
        },
        data(){
            return {
                totalRows: null,
                perPage: null,
                filters: {
                    sortBy: 'user_name',
                    sortDesc: false,
                    page: 1,
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
                        key: 'path_thumb_1',
                        sortable: false,
                        label: 'Изображение',
                    },
                    {
                        key: 'status',
                        sortable: true,
                        label: 'Статус',
                    },
                    {
                        key: 'actions',
                        sortable: false,
                        label: 'Действия',
                    },
                ],
                items: [],
                showForm: false,
                showMessage: false,
                taskId: null,
            }
        },
        mounted: function () {
            if (!this.editAvailable) {
                this.fields.pop();
            }
            this.retrieveTasks();
        },
        methods: {
            addTask: function () {
                this.taskId = null;
                this.showForm = true;
            },
            editTask: function(taskId) {
                this.taskId = taskId;
                this.showForm = true;
            },
            changeSorting: function(ctx) {
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
                        vueInstance.totalRows = parseInt(response.data.total_rows);
                        vueInstance.perPage = parseInt(response.data.per_page);
                    } else {
                        vueInstance.makeMessage('Ошибка', response.data.message);
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
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

</style>