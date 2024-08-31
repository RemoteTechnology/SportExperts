<script>
import {BASE_URL, ENDPOINTS, IDENTIFIER, MESSAGES, TOKEN} from "../../constant";
import { getUser, getInvitedOwnerRequest } from "../../api/UserRequest";
import { getEventRequest } from '../../api/EventRequest';
import { addNotificationUserInviteEventRequest } from '../../api/InvitedRequest';
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
import RadioButton from 'primevue/radiobutton';
import {createLogOptionRequest} from "../../api/CreateLogOptionRequest";

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
            dialogAthlete: false,
            emailInvited: '',
            invitedEmail: '',
            participant: [],
            whoInvited: null,
            invites: null,
            selectedInvite: null,
            invitedValue: null,
            options: null,
            inputOption: null,
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
        RadioButton: RadioButton,
    },
    methods: {
        formatDate: (inputDate) => {
            const [year, month, day] = inputDate.split('-');
            return `${day.padStart(2, '0')}.${month.padStart(2, '0')}.${year}`;
        },
        stripHtmlTags: function(html)
        {
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        },
        tokenRead: async function ()
        {
            this.token = await window.$cookies.get(TOKEN);
        },
        userIdentifier: async function ()
        {
            let attributes = {id: window.$cookies.get(IDENTIFIER)};
            await getUser(attributes)
                .then((response) => {
                    this.user = response.data.result.original;
                })
                .catch((error) => {
                    createLogOptionRequest({
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
                    createLogOptionRequest({
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
        search(event)
        {
            this.items = [...this.participants].map((item) => event.query + '-' + item);
        },
        recordToInvitedUser: async function ()
        {
            // Параметры user_id и invited_user_id перепутаны, надо смириться с этим и однажды вспомнить...
            let attributes = {
                event_id: this.eventId,
                user_id: window.$cookies.get(IDENTIFIER),
                invited_user_id: this.selectedInvite.who_user.id,
                // team_key: null,
            };
            await recordUserToEventRequest(attributes)
                .then((response) => {
                    this.messageSuccess = response.data.result.original ? MESSAGES.FORM_SUCCESS : MESSAGES.ERROR_ERROR;
                })
                .catch((error) => {
                    createLogOptionRequest({
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
        recordAndInvitedUser: async function()
        {
            let attributes = {
                email: this.invitedEmail,
                invite_user_id: this.user.id,
                event_id: this.eventId,
            };

            await addNotificationUserInviteEventRequest(attributes)
                .then((response) => {
                    this.messageSuccess = response.data.result.original ? MESSAGES.FORM_SUCCESS : MESSAGES.ERROR_ERROR;
                    this.invitedEmail = '';
                })
                .catch((error) => {
                    createLogOptionRequest({
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
        inviteToEvent: async function ()
        {
            if (this.invitedEmail.length > 0)
            {
                await this.recordAndInvitedUser();
                return;
            }
            if (this.selectedInvite) {
                await this.recordToInvitedUser();
                return;
            }
        },
        invited: function ()
        {
            let attributes = {
                event_id: this.eventId,
                user_id: this.user.id,
                // TODO: если регаться спортсменом, то не правильный "invited_user_id" записывается
                invited_user_id: window.$cookies.get(IDENTIFIER),
                // team_key: null,
            };

            recordUserToEventRequest(attributes)
                .then((response) => { this.messageSuccess = response.data.result.original ? MESSAGES.FORM_SUCCESS : MESSAGES.ERROR_ERROR; })
                .catch((error) => {
                    createLogOptionRequest({
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
        getWhoInvited: async function ()
        {
            let attributes = { who_user_id: window.$cookies.get(IDENTIFIER) };
            getInvitedOwnerRequest(attributes)
                .then((response) => { this.invites = response.data.result.original; })
                .catch((error) => {
                    console.log(error)
                    createLogOptionRequest({
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
    async beforeMount() {
        await this.tokenRead();
        await this.userIdentifier();
        if (this.user)
        {
            await this.getWhoInvited()
        }
        this.getUrl();
        this.getEvent();
    }
}
</script>

<template>
    <Dialog v-if="this.user && this.user.role === 'admin'"
            v-model:visible="this.dialog"
            maximizable
            modal
            header="Пригласить участника"
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
        <div v-if="this.invites.length > 0" class="mb-3">
            <label class="font-semibold w-6rem">Выберите спортсмена из списка</label>
            <Listbox v-model="this.selectedInvite"
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
            <InputText type="email" v-model="this.invitedEmail" class="w-100" />
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
            <Message severity="success">{{ this.messageSuccess }}</Message>
        </section>
        <section class="container d-flex d-between d-flex-wrap">
            <div class="w-50">
                <Image :src="this.baseUrl + 'storage/uploads/' + this.event.image.name"
                       imageStyle="max-width: 95%;"
                       :alt="this.event.name" />
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
                                <i class="pi pi-map-marker" style="color: #222"></i> <span>{{ this.event.location }}</span>
                            </h3>
                        </div>
                        <div class="mb-1">
                            <h3>
                                <i class="pi pi-calendar-clock" style="color: #222"></i> <span>{{ this.formatDate(this.event.start_date) }}</span>
                            </h3>
                        </div>
                        <div class="mb-1">
                            <h3>
                                <i class="pi pi-users" style="color: #222"></i> <span>{{ this.event.participants.length }} участников</span>
                            </h3>
                        </div>
                        <div class="mb-1">
                            <br>
                            <Button v-if="this.user && this.user.role === 'admin'"
                                    label="Записать спортсмена на событие"
                                    severity="primary"
                                    class="w-100"
                                    @click="this.dialog=true" />
                            <Button v-if="this.user && this.user.role === 'athlete'"
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
                            <section v-if="this.event.participants.length > 0">
                                <section v-for="participant in this.event.participants" class="option-list">
                                    <!-- TODO: проверить что участники события правильно изымаются из бд -->
                                    <div class="mb-3">
                                        <strong>
                                            <a href="#">{{ participant.first_name }} {{ participant.last_name }}</a><br>
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
