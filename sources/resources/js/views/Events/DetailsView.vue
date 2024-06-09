<script>
import {BASE_URL, ENDPOINTS, IDENTIFIER, MESSAGES, TOKEN} from "../../constant";
import { getUser, getInvitedOwnerRequest } from "../../api/UserRequest";
import { getEventRequest } from '../../api/EventRequest';
import { recordUserToEventRequest, eventRecordRequest } from '../../api/ParticipantRequest';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Image from 'primevue/image';
import Card from 'primevue/card';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Listbox from 'primevue/listbox';
import {loggingRequest} from "../../api/LoggingRequest";

export default {
    data(){
        return {
            baseUrl: BASE_URL,
            currentDate: new Date(),
            route: ENDPOINTS,
            messageError: null,
            messageSuccess: null,
            user: null,
            eventId: null,
            event: null,
            dialog: false,
            emailInvited: null,
            participantEmail: null,
            participant: null,
            whoInvited: null,
            invites: null,
            invitedValue: null,
        };
    },
    components: {
        Button: Button,
        Message: Message,
        Image: Image,
        DataTable: DataTable,
        Dialog: Dialog,
        Card: Card,
        Column: Column,
        ColumnGroup: ColumnGroup,
        InputText: InputText,
        Listbox: Listbox,
    },
    methods: {
        stripHtmlTags: function(html)
        {
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        },
        tokenRead: function ()
        {
            this.token = window.$cookies.get(TOKEN);
        },
        userIdentifier: function ()
        {
            let attributes = {id: window.$cookies.get(IDENTIFIER)};
            getUser(attributes)
                .then((response) => {
                    this.user = response.data.result.original;
                })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getUserRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.LOADING_ERROR;
                });
        },
        getUrl: function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            this.eventId = urlParams.get('id');
            this.invited.event_id = urlParams.get('id');
        },
        getEvent: function ()
        {
            let attributes = { id: this.eventId };
            getEventRequest(attributes)
                .then((response) => { this.event = response.data.result.original; })
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
        },
        addParticipant: function ()
        {
            let template = {event_id: null, user_id: null, invited_user_id: null, team_key: null};

        },
        search(event) {
            this.items = [...this.participants].map((item) => event.query + '-' + item);
        },
        inviteToEvent: function ()
        {
            let attributes = {
                event_id: this.eventId,
                user_id: this.invitedValue.id,
                invited_user_id: window.$cookies.get(IDENTIFIER),
                // team_key: null,
            };
            recordUserToEventRequest(attributes)
                .then((response) => { this.messageSuccess = response.data.result.original ? MESSAGES.FORM_SUCCESS : MESSAGES.ERROR_ERROR; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'recordUserToEventRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        invited: function ()
        {
            let attributes = {
                event_id: this.eventId,
                user_id: this.user.id,
                invited_user_id: window.$cookies.get(IDENTIFIER),
                // team_key: null,
            };
            recordUserToEventRequest(attributes)
                .then((response) => { this.messageSuccess = response.data.result.original ? MESSAGES.FORM_SUCCESS : MESSAGES.ERROR_ERROR; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'recordUserToEventRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        getWhoInvited: function ()
        {
            let attributes = { who_user_id: window.$cookies.get(IDENTIFIER) };
            getInvitedOwnerRequest(attributes)
                .then((response) => { this.invites = response.data.result.original; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getInvitedOwnerRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.LOADING_ERROR;
                });
        }
    },
    beforeMount() {
        this.tokenRead();
        this.userIdentifier();
        this.getUrl();
        this.getEvent();
        this.getWhoInvited()
    }
}
</script>

<template>
    <Dialog v-if="this.user.role === 'admin'"
            v-model:visible="this.dialog"
            maximizable
            modal
            header="Пригласить участника"
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
        <div v-if="this.invites.length > 0" class="mb-3">
            <label class="font-semibold w-6rem">Выберите спортсмена из списка</label>
            <Listbox v-model="this.invitedValue"
                     :options="this.invites"
                     class="w-100"
                     listStyle="max-height:310px">
                <template #option="slotProps">
                    <div class="flex align-items-center">
                        <div>{{ slotProps.option.user.first_name }} {{ slotProps.option.user.last_name }}</div>
                    </div>
                </template>
            </Listbox>
            <small>
                <b>Не нашли спортсмена? Воспользуйтесь формой ниже.</b>
            </small>
        </div>
        <div class="mb-3">
            <label class="font-semibold w-6rem">Отправить приглашение по E-mail</label>
            <InputText type="email" v-model="this.participantEmail" class="w-100" />
        </div>
        <div class="mb-3">
            <Button label="Записать на событие" severity="success" class="w-100" @click="this.inviteToEvent" />
        </div>
    </Dialog>
    <!-- Контентная часть -->
    <section v-if="this.event != null" class="mt-5 mb-5">
        <section class="mt-1 mb-2" v-if="this.messageError">
            <Message severity="error">{{ this.messageError }}</Message>
        </section>
        <section class="mt-1 mb-2" v-if="this.messageSuccess">
            <Message severity="error">{{ this.messageSuccess }}</Message>
        </section>
        <section class="container d-flex d-between d-flex-wrap">
            <div class="w-50">
                <Image :src="this.baseUrl + 'storage/uploads/' + this.event.image.name" :alt="this.event.name" />
                <div class="mt-3">
                    <h3>ИНФОРМАЦИЯ</h3>
                    <br>
                    <p style="
                        white-space: break-spaces;
                        line-height: 120%;
                        color: #323232;
                        width: 90%;
                    ">{{ this.stripHtmlTags(this.event.description) }}</p>
                </div>
            </div>
            <div class="w-50">
                <Card role="region">
                    <template #header>
                        <h2 class="text-center">{{ this.event.name }}</h2>
                    </template>
                    <template #content>
                        <div class="mb-1">
                            <h3>
                                <i class="pi pi-map-marker" style="color: #222"></i> <span>г. Новосибирск. пр. Маркса, 21/2</span>
                            </h3>
                        </div>
                        <div class="mb-1">
                            <h3>
                                <i class="pi pi-calendar-clock" style="color: #222"></i> <span>{{ this.event.start_date }}</span>
                            </h3>
                        </div>
                        <div class="mb-1">
                            <h3>
                                <i class="pi pi-users" style="color: #222"></i> <span>12 участников</span>
                            </h3>
                        </div>
                        <div class="mb-1">
                            <br>
                            <Button v-if="this.user.role === 'admin'"
                                    label="Записать спортсмена на событие"
                                    severity="primary"
                                    class="w-100"
                                    @click="this.dialog=true" />
                            <Button v-if="this.user.role === 'athlete'"
                                    label="Записаться"
                                    severity="primary"
                                    class="w-100"
                                    @click="this.invited" />
                        </div>
                    </template>
                </Card>
                <div class="mt-3">
                    <Card>
                        <template #header>
                            <h4 class="text-center">ПАРАМЕТРЫ</h4>
                        </template>
                        <template #content>
                            <section v-if="this.event['options'].length > 0">
                                <section v-for="option in this.event['options']" class="option-list">
                                    <!-- TODO: проверить что опции для события правильно изымаются из бд -->
                                    <div class="mb-3">
                                        <strong>
                                            <a href="#">{{ option.name }}</a>
                                        </strong><br>
                                        <span>{{ option.value }}</span>
                                    </div>
                                </section>
                            </section>
                        </template>
                    </Card>
                </div>
                <div class="mt-3">
                    <Card>
                        <template #header>
                            <h4 class="text-center">СПИСКИ</h4>
                        </template>
                        <template #content>
                            <section v-if="this.event['participants'].length > 0">
                                <section v-for="participant in this.event['participants']" class="option-list">
                                    <!-- TODO: проверить что участники события правильно изымаются из бд -->
                                    <div class="mb-3">
                                        <strong>
                                            <a href="#">{{ participant.first_name }} {{ participant.last_name }}</a><br>
                                            <span>{{ option.birth_date }}</span>
                                        </strong>
                                    </div>
                                </section>
                            </section>
                        </template>
                    </Card>
                </div>
            </div>
        </section>
    </section>
</template>

<style scoped>
i.pi{
    color: #3470bb!important;
    font-size: 1.2em;
    font-weight: bold;
}
.option-list a{
    color: #3470bb !important;
}
</style>
