<script>
import {BASE_URL, IDENTIFIER, TOKEN} from "../../constant";
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
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Card from 'primevue/card';
import Calendar from 'primevue/calendar';
import FileUpload from 'primevue/fileupload';

export default {
    data()
    {
        return {
            banner: null,
            baseUrl: BASE_URL,
            messageError: null,
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
        createEvent: function ()
        {
            if (this.options)
            {
                let inputFile = this.onUpload()
                    .then((response) => { this.event.image = response.data; })
                    .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });

                if (this.event.image.key)
                {
                    // TODO: разобраться почему событие создаётся со второго раза!!!!
                    createEventRequest({
                        user_id: this.event.user_id,
                        name: this.event.name,
                        description: this.event.description,
                        image: this.event.image.key,
                        start_date: this.event.start_date,
                        start_time: this.event.start_time,
                        expiration_date: this.event.expiration_date,
                        expiration_time: this.event.expiration_time,
                    })
                        .then((response) => { this.event = response.data.result.original; alert('ok!'); })
                        .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); alert('no!'); });
                    // Сохранение опций (параметров)
                    // TODO: вынести в отдельный метод
                    for (let i=0; i < this.options.length; i++)
                    {
                        createEventOptionRequest({
                            event_key: this.event.key,
                            entity: 'event',
                            name: this.options[i].name,
                            value: this.options[i].value,
                            type: this.options[i].type,
                        })
                            .then((response) => { console.log(response); this.event = response.data.result.original; })
                            .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); alert('error save option!'); });
                    }
                }
                else
                {
                    alert('add options!')
                }
            }
            else
            {
                alert('no file!')
            }
        },
        updateEvent: function ()
        {
            if (this.options.length > 0)
            {
                let formData = new FormData();
                console.log(this.event)
                if (this.$refs.fileInput.files[0])
                {
                    let inputFile = this.onUpload()
                        .then((response) => { this.event.image = response.data; })
                        .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
                }
                updateEventRequest({
                    id: this.event.id,
                    user_id: this.event.owner.id,
                    name: this.event.name,
                    description: this.event.description,
                    image: this.$refs.fileInput.files[0] ? this.event.image.key : this.event.image,
                    start_date: this.event.start_date,
                    start_time: this.event.start_time,
                    expiration_date: this.event.expiration_date,
                    expiration_time: this.event.expiration_time,
                })
                    .then((response) => { this.event = response.data.result.original; alert('ok update!'); })
                    .catch((error) => { /*TODO: тут надо что то придумать.*/ alert('no update!'); });
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
                            .then((response) => { console.log(response); this.event = response.data.result.original; })
                            .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); alert('error save option!'); });
                    }
                    else
                    {
                        createEventOptionRequest(option)
                            .then((response) => { console.log(response); this.event = response.data.result.original; })
                            .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); alert('error save option!'); });
                    }
                }
            }
            else
            {
                alert('no update options! please add их')
            }
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
            getEventRequest({ id: this.eventId })
                .then((response) => {
                    this.event = response.data.result.original;
                    this.options = this.event.options;
                })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
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
        <div class="mt-3">
            <h2 v-if="this.eventId" class="text-center">Создать новое спортивное событие</h2>
            <h2 v-else class="text-center">Создать новое спортивное событие</h2>
        </div>
        <section class="mt-1 mb-2" v-if="this.messageError !== null">
            <Message severity="error">{{ this.messageError }}</Message>
        </section>
        <section class="container d-flex d-between d-flex-wrap">
            <form class="w-50">
                <div class="form-block">
                    <label for="#">Введите название мероприятия</label>
                    <InputText type="text" v-model="event.name" class="w-100"/>
                </div>
                <div class="form-block">
                    <label for="#">Введите описание</label>
                    <!-- TODO: удалить html теги при сохранении в бд -->
                    <QuillEditor ref="editor"
                                 v-model:content="event.description"
                                 :options="editor"
                                 content-type="html"/>
                </div>
                <div class="form-block">
                    <Card>
                        <template #content>
                            <label class="text-center" for="#">Добавьте баннер</label>
                            <br>
                            <section class="d-flex d-center">
                                <!-- TODO: зафигачить эту кнопку -->
<!--                                <FileUpload ref="fileInput"-->
<!--                                            mode="basic"-->
<!--                                            name="file"-->
<!--                                            accept="image/*"-->
<!--                                            :maxFileSize="1000000"-->
<!--                                            chooseLabel="Загрузить" />-->
                                <!-- TODO: Выводить текущий баннер при обновлении -->
                                <input type="file" ref="fileInput" name="file" class="form-control">
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
                            @click="this.createEvent" />
                    <Button v-else
                            type="button"
                            label="Обновить"
                            class="w-100 mt-3"
                            severity="success"
                            @click="this.updateEvent" />
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
</style>
