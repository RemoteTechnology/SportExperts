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
import {createLogOptionRequest} from "../../api/CreateLogOptionRequest";
import {deleteOptionRequest} from "../../api/OptionRequest";
import AppAlertComponent from "../../components/AppAlertComponent.vue";
import AppEventFormComponent from "../../components/forms/AppEventFormComponent.vue";
import AppOptionsCardComponent from "../../components/cards/AppOptionsCardComponent.vue";

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
            file: null,
            options: []
        };
    },
    components: {
        AppOptionsCardComponent,
        AppEventFormComponent,
        AppAlertComponent,
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
        removeOption: async function (idx)
        {
            if ('id' in this.options[idx])
            {
                const attributes = {
                    id: this.options[idx].id
                };
                await deleteOptionRequest(attributes)
                    .catch(async(error) => {
                        console.log(error);
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'deleteOptionRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        this.messageError = MESSAGES.ERROR_ERROR;
                    });
            }
            this.options.splice(idx, 1);
        },
        onUpload: async function() {
            let formData = new FormData();
            await formData.append("file", this.$refs.fileInput.files[0]);
            return uploadFileRequest(formData);
        },
        createFile: async function ()
        {
            let attributes = '<FILE>';
            try {
                let inputFile = await this.onUpload()
                    .then(async (response) => {
                        console.log(response);
                        this.file = await response.data.key;
                    })
                    .catch(async (error) => {
                        console.log(error);
                        await createLogOptionRequest({
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
                image: this.file,
                location: this.event.location,
                start_date: this.event.start_date,
                start_time: this.event.start_time,
                expiration_date: this.event.expiration_date,
                expiration_time: this.event.expiration_time,
            };

            await createEventRequest(attributes)
                .then(async (response) => {
                    this.event = await response.data.result.original;
                    this.messageSuccess = MESSAGES.FORM_SUCCESS;
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
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
                    .then(async (response) => {
                        console.log(response);
                        this.event = await response.data.result.original;
                    })
                    .catch(async (error) => {
                        console.log(response);
                        await createLogOptionRequest({
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
            window.location = this.baseUrl;
        },
        updateEvent: async function()
        {
            // TODO: смещение даты назад
            let attributes = {
                id: this.event.id,
                name: this.event.name,
                description: this.event.description,
                location: this.event.location,
                start_date: this.event.start_date,
                start_time: this.event.start_time,
                expiration_date: this.event.expiration_date,
                expiration_time: this.event.expiration_time,
            };
            if (this.$refs.fileInput.files[0])
            {
                attributes.image = this.file
            }
            await updateEventRequest(attributes)
                .then(async (response) => {
                    this.event = await response.data.result.original;
                    this.messageSuccess = MESSAGES.FORM_SUCCESS;
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
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
        updateOrCreateOptions: async function ()
        {
            for (let i=0; i < this.options.length; i++)
            {
                if (Object.hasOwn(this.options[i], 'id'))
                {
                    let attributes = {
                        event_key: this.event.key,
                        entity: 'event',
                        name: this.options[i].name,
                        value: this.options[i].value,
                        type: this.options[i].type,
                    };
                    await updateEventOptionRequest(attributes)
                        .then(async (response) => {
                            console.log(response);
                            this.options = response.data.result.original;
                        })
                        .catch(async (error) => {
                            console.log(error);
                            await createLogOptionRequest({
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
                    const attributes = {
                        event_key: this.event.key,
                        entity: 'event',
                        name: this.options[i].name,
                        value: this.options[i].value,
                        type: 'string',
                    };
                    await createEventOptionRequest(attributes)
                        .then(async (response) => {
                            this.options = await response.data.result.original;
                        })
                        .catch(async (error) => {
                            console.log(error);
                            await createLogOptionRequest({
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
            await this.createFile();
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
        getEvent: async function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('id')) {
                let attributes = {id: this.eventId};
                await getEventRequest(attributes)
                    .then(async (response) => {
                        this.event = await response.data.result.original;
                        this.options = await this.event.options;
                    })
                    .catch(async (error) => {
                        await createLogOptionRequest({
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
    },
    async beforeMount() {
        this.getUserId();
        this.getUrl();
        await this.getEvent();
    }
}
</script>

<template>
    <section class="mt-5 mb-5">
        <AppAlertComponent
            :messageSuccess="this.messageSuccess"
            :messageError="this.messageError" />
        <div class="mt-3">
            <h2 v-if="this.eventId" class="text-center">Создать новое спортивное событие</h2>
            <h2 v-else class="text-center">Создать новое спортивное событие</h2>
        </div>
        <section class="container d-flex d-between d-flex-wrap">
            <AppEventFormComponent />
            <AppOptionsCardComponent />
        </section>
    </section>
</template>

<style scoped>
i.pi-times{
    color: red!important;
}
img{
    width: 100%;
}
</style>
