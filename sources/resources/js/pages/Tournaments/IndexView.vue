<script>
import {
    BASE_URL,
    MESSAGES,
    ENDPOINTS
} from '../../constant';
import { tournamentReadRequest } from '../../api/TournamentRequest';
import Message from 'primevue/message';
import Card from 'primevue/card';
import Button from "primevue/button";
import Dialog from 'primevue/dialog';
import OrderList from 'primevue/orderlist';
import LeaderLine from 'leader-line-vue';
import { createLogOptionRequest } from "../../api/CreateLogOptionRequest";
import { getUser } from "../../api/UserRequest";
import { readUserParticipantInvitedRequest } from "../../api/InvitedRequest";
import { getParticipantsToEventRequest } from "../../api/FilterRequest";
import {getFreeParticipantsRequest, tournamentValueCreateRequest} from "../../api/TournamentValueRequest";
import {
    participantUserRemoveAdditionallyRequest,
    participantUserReplaceAdditionallyRequest,
    participantUserSkipAdditionallyRequest
} from "../../api/ParticipantRequest";
import {getKeyEventRequest} from "../../api/EventRequest";

export default {
    data() {
        return {
            dialog: false,
            route: ENDPOINTS,
            currentDate: new Date(),
            messageError: null,
            baseUrl: BASE_URL,
            eventKey: '',
            event: null,
            values: null,
            tournamentFree: null,
            user: null,
            participantList: null,
            participant: {
                user: null,
                invite: null,
                users: null
            }
        };
    },
    components: {
        Card: Card,
        Message: Message,
        Button: Button,
        Dialog: Dialog,
        OrderList: OrderList,
    },
    methods: {
        formatDate(birthDate) {
            // Разбиваем исходную строку по символу "-"
            const [year, month, day] = birthDate.split('-');

            // Собираем дату в формате dd.mm.yyyy
            return `${day}.${month}.${year}`;
        },
        getUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            this.eventKey = urlParams.get('event');
        },
        getEvent: async function(eventKey) {
            const attributes = { key: eventKey };
            getKeyEventRequest(attributes)
                .then(async (response) => {
                    console.log(response)
                    this.event = await response.data.result.original;
                })
                .catch(async (error) => {
                    console.log(error)
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getKeyEventRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        openDialog(userId) {
            this.getParticipantInfo(userId)
            this.dialog=true;
        },
        closeDialog() {
            // TODO: тут может фигня
            // this.user = null;
            this.dialog = false;
            this.participant.user = null;
            this.participant.invite = null;
            this.participant.users = null;
        },
        async readTournament() {
            const attributes = {
                event_key: this.eventKey,
            };
            await tournamentReadRequest(attributes)
                .then(async (response) => {
                    this.values = await response.data.result.original;
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'tournamentReadRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        tyingAthlete() {
            for (let key in this.values.attributes)
            {
                this.values.attributes[key].forEach(async (value) => {
                    await value.tournament_values.forEach((participant) => {
                        try {
                            let line = new LeaderLine.setLine(
                                document.getElementById(participant.participants_A.key),
                                document.getElementById(participant.participants_B.key),
                                {
                                    color: "#5c5c5c",
                                    path: "arc",
                                    endPlug: "behind",
                                }
                            );
                            line.setOptions({ startSocket: 'top', endSocket: 'right' });
                        } catch (e)
                        {
                            console.log('Message Error: ' + e.message)
                        }
                    });
                });
            }
        },
        getUserParticipant: async function(id) {
            const attributes = {
                id: id
            }
            await getUser(attributes)
                .then(async (response) => {
                    this.participant.user = await response.data.result.original;
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getUser',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
        },
        getUserInvite: async function(userId) {
            const attributes = {
                user_id: userId
            };
            await readUserParticipantInvitedRequest(attributes)
                .then(async (response) => {
                    this.participant.invite = await response.data.result.original;
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'readUserParticipantInvitedRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
        },
        getFreeParticipantList: async function() {
            const attributes = {
                event_key: this.eventKey
            };
            getFreeParticipantsRequest(attributes)
                .then(async (response) => {
                    this.tournamentFree = await response.data.result.original;
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getFreeParticipantsRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
        },
        getListParticipants: async function(eventKey, mode='card') {
            const attributes = {
                event_key: eventKey
            };
            await getParticipantsToEventRequest(attributes)
                .then(async (response) => {
                    if (mode === 'card')
                    {
                        this.participant.users = await response.data.result.original;
                    }
                    else {
                        this.participantList = await response.data.result.original;
                    }
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getParticipantsToEventRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
        },
        dropTournamentParticipant: async function()
        {
            const attributes = {
                event_key: this.eventKey,
                user_id: this.participant.user.id
            };
            await participantUserRemoveAdditionallyRequest(attributes)
                .then(async (response) => {
                    if (response.data.result.original.id)
                    {
                       this.closeDialog();
                       await this.readTournament();
                    }
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'participantUserRemoveAdditionallyRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
        },
        replaceToParticipant: async function(dataAttributes)
        {
            const attributes = dataAttributes;
            await participantUserReplaceAdditionallyRequest(attributes)
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'participantUserReplaceAdditionallyRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
        },
        skipToParticipant: async function(participant)
        {
            const attributes = {
                event_key: this.eventKey,
                ...participant
            };
            await participantUserSkipAdditionallyRequest(attributes)
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'participantUserSkipAdditionallyRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
        },
        getParticipantInfo: async function(userId) {
            await this.getUserParticipant(userId);
            await this.getUserInvite(this.participant.user.id);
            await this.getListParticipants(this.eventKey);
        },
        createParticipantTournament(userId) {
            const attributes = {
                event_key: this.eventKey,
                user_id: userId,
            };
            tournamentValueCreateRequest(attributes)
                .then(async (response) => {
                    await this.getListParticipants(this.eventKey, 'page');
                    await this.readTournament();
                    await this.$nextTick(() => {
                        this.tyingAthlete();
                    });



                })
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'tournamentValueCreateRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                });
        },
    },

    async mounted() {
        await this.getUrl();
        await this.getEvent(this.eventKey,);
        await this.getListParticipants(this.eventKey, 'page');
        await this.readTournament();
        await this.getFreeParticipantList();
        await this.$nextTick(() => {
            this.tyingAthlete();
        });
    }
};
</script>

<template>
<!--    TODO: отрисовать шаги-->
<!--    TODO: добавить админов, сделать им систему прав аля круд-->
    <Dialog v-model:visible="this.dialog"
            maximizable
            modal
            header="Параметры спортсмена"
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
        <div class="mb-3">
            <section class="d-flex d-between d-align-center">
                <div class="w-70">
                    <section>
                        <h2>{{ this.participant.user.last_name }} {{ this.participant.user.first_name }}</h2>
                    </section>
                    <section class="mb-1 mt-1">
                        <p>({{ this.participant.user.age }} лет)</p>
                        <p><b>Дата рождения:</b> {{ this.formatDate(this.participant.user.birth_date) }}</p>
                        <section v-for="option in this.participant.user.options" :key="option.name">
                            <p v-if="option.name === 'Height'"><b>Рост:</b> {{ option.value }} см</p>
                            <p v-if="option.name === 'Weight'"><b>Вес:</b> {{ option.value }} кг</p>
                        </section>
                    </section>
                    <section>
                        <p><b>Пригласил:</b> {{ this.participant.invite.who_user.last_name }} {{ this.participant.invite.who_user.first_name }}</p>
                    </section>
                </div>
                <div class="w-30">
                    <div class="mb-2">
                        <Button label="Дисквалифицировать"
                                severity="danger"
                                class="w-100"
                                @click="this.dropTournamentParticipant()" />
                    </div>
                    <div class="mb-2">
                        <Button label="Пропустить"
                                severity="success"
                                class="w-100"
                                @click="this.skipToParticipant({user_id: this.participant.user.id})" />
                    </div>
                </div>
            </section>
            <hr>
            <h3 class="text-center">Заменить спортсмена</h3>
            <section>
                <div v-for="item in this.participant.users"
                     :key="item.user_id"
                     class="d-flex d-between d-align-center d-flex-wrap">
                    <div class="w-70">
                        <p>
                            <strong>{{ item.user.first_name }} {{ item.user.last_name }}</strong>
                        </p>
                        <section>
                            <small>
                                Возраст: {{ item.user.age }} лет
                            </small>
                        </section>
                        <section v-for="option in item.user.options"
                                 :key="option.name">
                            <small v-if="option.name === 'Height'">
                                Рост: {{ option.value }} см
                            </small>
                            <small v-if="option.name === 'Weight'">
                                Вес: {{ option.value }} кг
                            </small>
                        </section>
                    </div>
                    <div class="w-30">
                        <Button label="Заменить"
                                severity="primary"
                                class="w-100"
                                @click="this.replaceToParticipant({
                                    event_key: this.eventKey,
                                    new_participant_key: item.key,
                                    user_id: this.participant.invite.user.id,
                                })"/>
                    </div>
                    <hr class="w-100">
                </div>
            </section>
        </div>
    </Dialog>
    <section class="d-center">
        <section class="mt-5">
            <section class="mt-1 mb-2" v-if="this.messageError !== null">
            <Message severity="error">{{ this.messageError }}</Message>
        </section>
        <section v-if="this.event">
            <h2 class="mb-2 text-center">{{ this.event.name }}</h2>
        </section>
        <div v-if="this.values != null && Object.keys(this.values).includes('attributes')" class="d-flex d-between">
            <div class="w-30 d-flex d-end">
                <Card class="mb-3 w-95 h-40">
                    <template #content>
                        <section v-if="this.participantList">
                            <h3>Свободные спортсмены</h3>
                            <br>
                            <OrderList v-model="this.tournamentFree" listStyle="height:auto" dataKey="id">
                                <template #item="slotProps">
                                    <section class="d-flex d-between d-align-center">
                                        <section class="w-70">
                                            <p>{{ slotProps.item.user.first_name }} {{ slotProps.item.user.last_name }}</p>
                                            <small>Возраст: {{ slotProps.item.user.age }}
                                                <span v-for="option in slotProps.item.user.options" :key="option.name">
                                                    <span v-if="option.name === 'Height'"> | Рост: {{ option.value }} см</span>
                                                    <span v-if="option.name === 'Weight'"> | Вес: {{ option.value }} кг</span>
                                                </span>
                                            </small>
                                        </section>
                                        <section class="w-30 d-flex d-end">
                                            <Button icon="pi pi-arrow-right"
                                                    aria-label="Success"
                                                    @click="this.createParticipantTournament(slotProps.item.user.id)" />
                                        </section>
                                    </section>
                                </template>
                            </OrderList>
                        </section>
                    </template>
                </Card>
            </div>
            <div v-for="attribute in this.values.attributes" class="w-70">
                <template v-for="tournament in attribute" :key="tournament.id">
                    <section id="tid" class="d-flex d-between d-align-center">
                        <section style="width: 150%;">
                            <section id="step-tournament">
                                <Card class="mb-3">
                                    <template #content>
                                        <strong># {{ tournament.stage }} ЭТАП</strong>
                                    </template>
                                </Card>
                            </section>
                            <template v-for="value in tournament.tournament_values">
                                <section id="body-tournament">
                                    <Card class="mt-1">
                                        <template #content>
                                            <section id="athlete-card" class="d-flex d-between">
                                                <span>{{ value.users[0].first_name }} {{ value.users[0].last_name }}</span>
                                                <Button icon="pi pi-cog" severity="info" @click="this.openDialog(value.users[0].id)" />
                                            </section>
                                            <span class="flag"  :id="value.participants_A.key"></span>
                                            <small>Команда</small>
                                        </template>
                                    </Card>
                                    <Card class="mt-1">
                                        <template #content v-if="value.users[1] !== null">
                                            <section id="athlete-card" class="d-flex d-between">
                                                <span>{{ value.users[1].first_name }} {{ value.users[1].last_name }}</span>
                                                <Button icon="pi pi-cog" severity="info" @click="this.openDialog(value.users[1].id)" />
                                            </section>
                                            <span class="flag" :id="value.participants_B.key"></span>
                                            <small>Команда</small>
                                        </template>
                                        <template #content v-else>
                                            <span style="color: #bd3131">
                                                <i>(Нет соперника)</i>
                                            </span>
                                        </template>
                                    </Card>
                                </section>
                            </template>

                        </section>
                    </section>
                </template>
            </div>
        </div>
    </section>
</section>
</template>
