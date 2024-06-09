<script>
import {BASE_URL, ENDPOINTS, IDENTIFIER, MESSAGES, TOKEN} from "../../constant";
import {
    createEventRequest,
    getEventRequest,
    updateEventRequest,
    createEventOptionRequest,
    updateEventOptionRequest,
} from '../../api/EventRequest';
import { uploadFileRequest } from '../../api/FileRequest';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Image from 'primevue/image';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Card from 'primevue/card';
import Calendar from 'primevue/calendar';
import FileUpload from 'primevue/fileupload';
import {loggingRequest} from "../../api/LoggingRequest";

export default {
    data() {
        return {
            banner: null,
            baseUrl: BASE_URL,
            currentDate: new Date(),
            route: ENDPOINTS,
            messageError: null,
            messageSuccess: null,
            optionName: null,
            optionValue: null,
            eventId: null,
            editor: {
                toolbar: 'essential',
                placeholder: '...',
                theme: 'snow',
            },
            event: {
                user_id: 1,
                name: null,
                description: null,
                image: null,
                location: null,
                start_date: null,
                start_time: null,
                expiration_date: null,
                expiration_time: null,
            },
            options: []
        };
    },
    components: {
        Button: Button,
        Message: Message,
        InputText: InputText,
        Textarea: Textarea,
        // Editor: Editor,
        QuillEditor: QuillEditor,
        Image: Image,
        Card: Card,
        Calendar: Calendar,
        FileUpload: FileUpload,
    },
    methods: {
        getUserId: function ()
        {
            this.token = window.$cookies.get(IDENTIFIER);
        },
        addOption: function()
        {
            this.options = [...this.options, {
                name: this.optionName,
                type: 'string', //TODO: в ясный и прекрасный день вернуться к вопросу о прокидывании типа
                value: this.optionValue
            }];
            this.optionName = null;
            this.optionValue = null;
        },
        removeOption: function (idx)
        {
            this.options.splice(idx, 1);
        },
        onUpload() {
            let formData = new FormData();
            formData.append("file", this.$refs.fileInput.files[0]);
            return uploadFileRequest(formData);
        },
        createFile: async function ()
        {
            let attributes = '<FILE>';
            try {
                let inputFile = await this.onUpload()
                    .then((response) => {
                        this.event.image = response.data.key;
                    })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'uploadFileRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        this.messageError = MESSAGES.ERROR_ERROR;
                    });
            } catch (error) {

            }
        },
        createEvent: async function ()
        {
            let attributes = {
                user_id: window.$cookies.get(IDENTIFIER),
                name: this.event.name,
                description: this.event.description,
                image: this.event.image,
                start_date: this.event.start_date,
                start_time: this.event.start_time,
                expiration_date: this.event.expiration_date,
                expiration_time: this.event.expiration_time,
            };

            await createEventRequest(attributes)
                .then((response) => {
                    this.event = response.data.result.original;
                    this.messageSuccess = MESSAGES.FORM_SUCCESS;
                })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'createEventRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        createOptions: async function ()
        {
            const eventKey = this.event.key;
            for (let i=0; i < this.options.length; i++)
            {
                let attributes = {
                    event_key: eventKey,
                    entity: 'event',
                    name: this.options[i].name,
                    value: this.options[i].value,
                    type: this.options[i].type,
                };
                await createEventOptionRequest(attributes)
                    .then((response) => { this.event = response.data.result.original; })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'createEventOptionRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        this.messageError = MESSAGES.ERROR_ERROR;
                    });
            }
        },
        createEventObject: async function ()
        {
            await this.createFile();
            await this.createEvent();
            await this.createOptions();
        },
        updateEvent: async function()
        {
            let attributes = {
                id: this.event.id,
                name: this.event.name,
                description: this.event.description,
                start_date: this.event.start_date,
                start_time: this.event.start_time,
                expiration_date: this.event.expiration_date,
                expiration_time: this.event.expiration_time,
            };
            if (this.$refs.fileInput.files[0])
            {
                attributes.image = this.event.image.key;
            }
            updateEventRequest(attributes)
                .then((response) => {
                    this.event = response.data.result.original;
                    this.messageSuccess = MESSAGES.FORM_SUCCESS;
                })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'updateEventRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        updateOrCreateOptions: function ()
        {
            for (let i=0; i < this.options.length; i++)
            {
                let option = {
                    event_key: this.event.key,
                    entity: 'event',
                    name: this.options[i].name,
                    value: this.options[i].value,
                    type: this.options[i].type,
                };
                if (Object.hasOwn(this.options[i], 'id'))
                {
                    updateEventOptionRequest(option)
                        .then((response) => { this.options = response.data.result.original; })
                        .catch((error) => {
                            loggingRequest({
                                current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                method: 'updateEventOptionRequest',
                                status: error.code,
                                request_data: option.toString(),
                                message: error.message
                            });
                            this.messageError = MESSAGES.ERROR_ERROR;
                        });
                }
                else
                {
                    createEventOptionRequest(option)
                        .then((response) => { this.options = response.data.result.original; })
                        .catch((error) => {
                            loggingRequest({
                                current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                method: 'createEventOptionRequest',
                                status: error.code,
                                request_data: option.toString(),
                                message: error.message
                            });
                            this.messageError = MESSAGES.ERROR_ERROR;
                        });
                }
            }
        },
        updateEventObject: async function()
        {
            // await this.createFile();
            await this.updateEvent();
            await this.updateOrCreateOptions();

        },
        getUrl: function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams)
            {
                this.eventId = urlParams.get('id');
            }
        },
        getEvent: function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('id')) {
                let attributes = {id: this.eventId};
                getEventRequest(attributes)
                    .then((response) => {
                        this.event = response.data.result.original;
                        this.options = this.event.options;
                    })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getEventRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        this.messageError = MESSAGES.LOADING_ERROR;
                    });
            }
        },
        editorLoad: function ({instance})
        {
            const delta = this.$refs.editor.quill.clipboard.convert({ html: this.event.description });
            this.$refs.editor.quill.setContents(delta, 'silent');
        }
    },
    beforeMount() {
        this.getUserId();
        this.getUrl();
        this.getEvent();
    }
}
</script>

<template>
    <section class="mt-5 mb-5">
        <section class="mt-1 mb-2" v-if="this.messageError">
            <Message severity="error">{{ this.messageError }}</Message>
        </section>
        <section class="mt-1 mb-2" v-if="this.messageSuccess">
            <Message severity="success">{{ this.messageSuccess }}</Message>
        </section>
        <div class="mt-3">
            <h2 v-if="this.eventId" class="text-center">Создать новое спортивное событие</h2>
            <h2 v-else class="text-center">Создать новое спортивное событие</h2>
        </div>
        <section class="container d-flex d-between d-flex-wrap">
            <form class="w-50">
                <div class="form-block">
                    <label for="#">Введите название мероприятия</label>
                    <InputText type="text" v-model="event.name" class="w-100"/>
                </div>
                <div class="form-block">
                    <label for="#">Введите описание</label>
                    <!-- TODO: удалить или применить html теги при сохранении в бд -->
                    <QuillEditor ref="editor"
                                 v-model:content="event.description"
                                 :options="editor"
                                 content-type="html"/>
                </div>
                <div class="form-block">
                    <Card>
                        <template #content>
                            <section v-if="this.eventId" class="mb-3">
                                <p>Текущий баннер события:</p>
                                <Image :src="this.baseUrl + 'storage/uploads/' + event.image.name"
                                       :alt="event.name"
                                       style="display:block;"
                                       class="w-74"
                                       preview />
                            </section>
                            <label class="text-center" for="#">Добавьте баннер</label>
                            <br>
                            <section class="d-flex d-center">
                                <!-- TODO: зафигачить эту кнопку -->
                                <FileUpload ref="fileInput"
                                            mode="basic"
                                            name="file"
                                            accept="image/*"
                                            :maxFileSize="1000000"
                                            chooseLabel="Загрузить" />
<!--                                <input type="file" ref="fileInput" name="file" class="form-control">-->
                            </section>
                        </template>
                    </Card>
                </div>
                <div class="d-flex d-between">
                    <div class="form-block w-70">
                        <label for="#">Укажите дату старта</label>
                        <Calendar v-model="event.start_date" class="w-70" />
                    </div>
                    <div class="form-block w-70">
                        <label for="#">Укажите время старта</label>
                        <InputText type="time" v-model="event.start_time" class="w-70" />
                    </div>
                </div>
                <div class="d-flex d-between">
                    <div class="form-block w-70">
                        <label for="#">Укажите дату старта</label>
                        <Calendar v-model="event.expiration_date" class="w-70" />
                    </div>
                    <div class="form-block w-70">
                        <label for="#">Укажите время старта</label>
                        <InputText type="time" v-model="event.expiration_time" class="w-70" />
                    </div>
                </div>
                <section class="mb-5">
                    <Button v-if="this.eventId == null"
                            type="button"
                            label="Создать событие"
                            class="w-100 mt-3"
                            severity="success"
                            @click="this.createEventObject" />
                    <Button v-else
                            type="button"
                            label="Обновить"
                            class="w-100 mt-3"
                            severity="success"
                            @click="this.updateEventObject" />
                </section>
                <br>
            </form>
            <section class="w-25" style="
                position: relative;
                left: -10%;
            ">
                <Card>
                    <template #header>
                        <h4 class="text-center">Параметры</h4>
                    </template>
                    <template #content>
                        <form>
                            <section class="mb-3">
                                <div class="mb-3">
                                    <label for="#">Название параметра</label>
                                    <InputText type="text" v-model="this.optionName" class="w-100" />
                                </div>
                                <div class="mb-3">
                                    <label for="#">Значение параметра</label>
                                    <InputText type="text" v-model="this.optionValue" class="w-100" />
                                </div>
                                <Button type="button"
                                        label="Добавить параметр"
                                        class="w-100 mt-3"
                                        severity="success"
                                        @click="this.addOption" />
                            </section>
                        </form>
                    </template>
                </Card>
                <section class="mt-3">
                    <Card v-for="(option, idx) in this.options" class="mt-1">
                        <template #header>
                            <div class="d-flex d-end" style="
                                position: relative;
                                right: 5%;
                                top: 0.7em;
                            ">
                                <i class="pi pi-times pointer" @click="this.removeOption(idx)"></i>
                            </div>
                        </template>
                        <template #content>
                            <strong>{{ option.name }}</strong><br>
                            <span>{{ option.value }}</span>
                        </template>
                    </Card>
                </section>
            </section>
        </section>
    </section>
    <div class="mb-5"></div>
</template>

<style scoped>
i.pi-times{
    color: red!important;
}
img{
    width: 100%;
}
</style>
