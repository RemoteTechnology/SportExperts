<script>
import {BASE_URL, TOKEN, IDENTIFIER, MESSAGES, RESPONSE, ENDPOINTS} from '../../constant';
import { getUser } from '../../api/UserRequest';
import { loggingRequest } from '../../api/LoggingRequest';
import {
    createArchiveRequest,
    removeArchiveRequest
} from '../../api/ArchiveRequest';
import {
    getRecordToEventsRequest,
    getEventOwnerRequest,
    getEventParticipantRequest
} from '../../api/FilterRequest';
import Card from 'primevue/card';
import DataView from 'primevue/dataview';
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Image from 'primevue/image';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Paginator from 'primevue/paginator';
import Row from 'primevue/row';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import InlineMessage from 'primevue/inlinemessage';


export default {
    computed: {
        RESPONSE() {
            return RESPONSE
        }
    },
    data() {
        return {
            baseUrl: BASE_URL,
            currentDate: new Date(),
            route: ENDPOINTS,
            id: null,
            user: null,
            participants: [],
            invited: [],
            token: null,
            events: [],
            eventsNoActive: [],
            eventsArchive: [],
            first: 0,
            messageError: null,
            messageSuccess: null,
        };
    },
    components: {
        Card: Card,
        DataView: DataView,
        DataViewLayoutOptions: DataViewLayoutOptions,
        InputText: InputText,
        Paginator: Paginator,
        Button: Button,
        Message: Message,
        Image: Image,
        DataTable: DataTable,
        Column: Column,
        ColumnGroup: ColumnGroup,
        Row: Row,
        TabView: TabView,
        TabPanel: TabPanel,
        InlineMessage: InlineMessage,
    },
    methods: {
        short: (str, maxlen) => str.length <= maxlen ? str : str.slice(0, maxlen) + '...',
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
        tokenRead: function ()
        {
            this.token = window.$cookies.get(TOKEN);
        },
        logout: function ()
        {
            window.$cookies.remove(TOKEN);
            window.$cookies.remove(IDENTIFIER);
            window.location = this.baseUrl;
        },
        userReadToEvent: function ()
        {
            let attributes = `user_id:${window.$cookies.get(IDENTIFIER)}`;
            getRecordToEventsRequest(attributes, 'after')
                .then((response) => { console.log(response);this.events = response.data.result.original; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getRecordToEventsRequest',
                        status: error.code,
                        request_data: attributes.toString() + 'mode:after',
                        message: error.message
                    });
                    this.messageError = MESSAGES.LOADING_ERROR;
                });
        },
        getEventOwner: function ()
        {
            let attributes = {
                filter: `user_id:${window.$cookies.get(IDENTIFIER)}`,
                mode: 'all',
                limit: 10,
                startDate: true,
                status: 'Active'
            };
            getEventOwnerRequest(attributes)
                .then((response) => { this.events = response.data.result.original; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getEventOwnerRequest',
                        status: error.code,
                        request_data: attributes.toString() + ', mode:after, limit:9, startDate:false',
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
            // if (user.role == 'admin')
            // {
                let attributes2 = {
                    filter: `user_id:${window.$cookies.get(IDENTIFIER)}`,
                    mode: 'after',
                    limit: 9,
                    startDate: false,
                    status: 'No active'
                };
                getEventOwnerRequest(attributes2)
                    .then((response) => { this.eventsNoActive = response.data.result.original; })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getEventOwnerRequest',
                            status: error.code,
                            request_data: attributes2.toString(),
                            message: error.message
                        });
                        this.messageError = MESSAGES.NO_DATA;
                    });

                let attributes3 = {
                    filter: `user_id:${window.$cookies.get(IDENTIFIER)}`,
                    mode: 'before',
                    limit: 9,
                    startDate: false,
                    status: 'Archive'
                };
                getEventOwnerRequest(attributes3)
                    .then((response) => { this.eventsArchive = response.data.result.original; })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getEventOwnerRequest',
                            status: error.code,
                            request_data: attributes3.toString(),
                            message: error.message
                        });
                        this.messageError = MESSAGES.NO_DATA;
                    });
            // }
        },
        getParticipants: function ()
        {
            let attributes = `invited_user_id:${window.$cookies.get(IDENTIFIER)}`;
            getEventParticipantRequest(attributes)
                .then((response) => { this.participants = response.data.result.original; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getEventParticipantRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_DATA;
                });
        },
        addEventToArchive: function (eventKey)
        {
            let attributes = { key: eventKey };
            createArchiveRequest(attributes)
                .then((response) => {
                    this.messageSuccess = MESSAGES.NO_DATA;
                    this.getEventOwner();
                })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getEventParticipantRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_DEFAULT;
                });
        },
        removeEventToArchive: function (eventKey)
        {
            let attributes = { key: eventKey };
            removeArchiveRequest(attributes)
                .then((response) => {
                    this.messageSuccess = MESSAGES.NO_DATA;
                    this.getEventOwner();
                })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getEventParticipantRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_DEFAULT;
                });
        }
    },
    beforeMount() {
        this.tokenRead();
        this.userIdentifier();
        this.userReadToEvent();
        this.getEventOwner();
        this.getParticipants();
    }
}
</script>

<template>
    <section class="d-flex d-center">
        <div v-if="this.user"  class="text-center mt-3 mb-3">
            <h2>Профиль
                <span v-if="this.user.role === 'admin'">Администратора</span>
                <span v-if="this.user.role === 'athlete'">Спортсмена</span></h2>
        </div>
    </section>
    <section class="mt-1 mb-2" v-if="this.messageSuccess">
        <Message severity="success">{{ this.messageSuccess }}</Message>
    </section>
    <section class="mt-1 mb-2" v-if="this.messageError">
        <Message severity="error">{{ this.messageError }}</Message>
    </section>
    <section class="d-flex d-between container">
        <div class="w-30">
            <section class="w-100">
                <Card>
                    <template #content>
                        <div class="d-flex d-center">
                            <section>
                                <Image src="images/athlete_default_avatar.png" width="250" />
                                <div class="mt-06 d-flex d-center">
                                    <h2>
                                        <strong>{{ this.user.first_name }} {{ this.user.last_name }}</strong> <br>
                                        <small>{{ this.user.first_name_eng }} {{ this.user.last_name_eng }}</small>
                                    </h2>
                                </div>
                                <div class="mt-06">
                                    <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.CREATE">
                                        <Button label="Создать событие" class="w-100" severity="success" />
                                    </a>
                                </div>
                                <div class="mt-06">
                                    <a :href="this.baseUrl + this.route.PROFILE + this.route.BASE + this.route.SETTINGS">
                                        <Button type="button" label="Настройки" class="w-100" severity="primary"/>
                                    </a>
                                </div>
                                <div class="mt-06">
                                    <Button type="button" label="Выход" class="w-100" severity="danger" @click="logout"/>
                                </div>
                            </section>
                        </div>
                    </template>
                </Card>
            </section>
            <section class="w-100 mt-5">
                <!-- Виджет приглашенных спортсменов -->
                <Card v-if="this.user.role === 'admin' && this.invited.length > 0">
                    <section>
                        <a href="#">
                            <Button type="button" label="Полный список спортсменов" severity="primary"/>
                        </a>
                    </section>
                    <template #header>
                        <div class="d-flex d-center">
                            <h4>Ваши спортсмены:</h4>
                        </div>
                    </template>
                    <template #content>
                        <DataTable :value="this.invited['data']">
                            <Column header="">
                                <template #body>
                                    <Image src="images/athlete_default_avatar.png" width="30" />
                                </template>
                            </Column>
                            <Column field="user.first_name" header="Имя"></Column>
                            <Column field="user.last_name" header="Фамилия"></Column>
                            <Column header="">
                                <template #body>
                                    <a href="#">
                                        <Button type="button" label="Подробнее" severity="secondary"/>
                                    </a>
                                </template>
                            </Column>
                        </DataTable>
                    </template>
                    <template #footer>
                        <Paginator :rows="10" :totalRecords="120"></Paginator>
                    </template>
                </Card>
            </section>
        </div>
        <div class="w-70">
            <!-- ADMIN VIEW -->
            <section v-if="this.user.role === 'admin'" class="mb-3">
                <Card>
                    <template #content>
                        <section>
                            <h2 class="mb-3">Спортивные события которые вы создали</h2>
                        </section>
                        <TabView>
                            <TabPanel header="Активные">
                                <section v-if="this.events[RESPONSE.data].length > 0">
                                    <section v-for="event in this.events[RESPONSE.data]" class="mt-1 mb-1">
                                        <Card class="w-100">
                                            <template #content>
                                                <div class="d-flex d-between d-align-center">
                                                    <div class="w-30">
                                                        <div :style="
                                                                'background-size: cover;' +
                                                                'background-position: center top;' +
                                                                'background-image: url(' + this.baseUrl + 'storage/uploads/' + event.image.name + ');' +
                                                                'height: 10em;' +
                                                                'width: 80%;' +
                                                                'background-repeat: round;' +
                                                                'border-radius: 0.5em'
                                                        "></div>
                                                    </div>
                                                    <div class="w-70">
                                                        <div class="d-flex d-between">
                                                            <section class="w-40">
                                                                <p>
                                                                    <strong>{{ event.name }}</strong>
                                                                </p>
                                                                <small>{{ event.start_date }} {{ event.start_time }}</small><br />
                                                                <small>{{ event.expiration_date }} {{ event.expiration_time }}</small>
                                                            </section>
                                                            <section>
                                                                <p>
                                                                    <strong>Статус:</strong>
                                                                </p>
                                                                <InlineMessage severity="success">Активное событие</InlineMessage>
                                                            </section>
                                                            <section>
                                                                <p>Участников: {{ this.participants.length > 0 ? this.participants.length : 0 }}</p>
                                                                <div class="mb-1">
                                                                    <a :href="this.baseUrl + this.route.EVENT + '?id=' + event.id">
                                                                        <Button label="Подробнее" severity="secondary" outlined class="w-100" />
                                                                    </a>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.UPDATE + '?id=' + event.id">
                                                                        <Button label="Редактировать" severity="primary" outlined class="w-100" />
                                                                    </a>
                                                                </div>
                                                                <div>
                                                                    <Button label="В архив"
                                                                            severity="warning"
                                                                            outlined
                                                                            class="w-100"
                                                                            @click="this.addEventToArchive(event.key)"/>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </Card>
                                    </section>
                                    <div class="w-100">
                                        <Paginator :rows="10" :totalRecords="120"></Paginator>
                                    </div>
                                </section>
                                <section v-else class="d-flex d-center">
                                    <InlineMessage severity="warn" class="w-70">Данных нет</InlineMessage>
                                </section>
                            </TabPanel>
                            <TabPanel header="Прошедшие">
                                <section v-if="this.eventsNoActive[RESPONSE.data].length > 0">
                                    <section v-for="event in this.eventsNoActive[RESPONSE.data]" class="mt-1 mb-1">
                                        <Card class="w-100">
                                            <template #content>
                                                <div class="d-flex d-between d-align-center">
                                                    <div class="w-30">
                                                        <div :style="
                                                                'background-size: cover;' +
                                                                'background-position: center top;' +
                                                                'background-image: url(' + this.baseUrl + 'storage/uploads/' + event.image.name + ');' +
                                                                'height: 10em;' +
                                                                'width: 80%;' +
                                                                'background-repeat: round;' +
                                                                'border-radius: 0.5em'
                                                        "></div>
                                                    </div>
                                                    <div class="w-70">
                                                        <div class="d-flex d-between">
                                                            <section class="w-40">
                                                                <p>
                                                                    <strong>{{ event.name }}</strong>
                                                                </p>
                                                                <small>{{ event.start_date }} {{ event.start_time }}</small><br />
                                                                <small>{{ event.expiration_date }} {{ event.expiration_time }}</small>
                                                            </section>
                                                            <section>
                                                                <p>
                                                                    <strong>Статус:</strong>
                                                                </p>
                                                                <InlineMessage severity="secondary">Событие завершено</InlineMessage>
                                                            </section>
                                                            <section>
                                                                <p>Участников: {{ this.participants.length > 0 ? this.participants.length : 0 }}</p>
                                                                <div class="mb-1">
                                                                    <a :href="this.baseUrl + this.route.EVENT + '?id=' + event.id">
                                                                        <Button label="Подробнее" severity="secondary" outlined class="w-100" />
                                                                    </a>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.UPDATE + '?id=' + event.id">
                                                                        <Button label="Редактировать" severity="primary" outlined class="w-100" />
                                                                    </a>
                                                                </div>
                                                                <div>
                                                                    <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.UPDATE + '?id=' + event.id">
                                                                        <Button label="В архив" severity="warning" outlined class="w-100" />
                                                                    </a>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </Card>
                                    </section>
                                    <div class="w-100">
                                        <Paginator :rows="10" :totalRecords="120"></Paginator>
                                    </div>
                                </section>
                                <section v-else class="d-flex d-center">
                                    <InlineMessage severity="warn" class="w-70">Данных нет</InlineMessage>
                                </section>
                            </TabPanel>
                            <TabPanel header="В архиве">
                                <section v-if="this.eventsArchive[RESPONSE.data].length > 0">
                                    <section v-for="event in this.eventsArchive[RESPONSE.data]" class="mt-1 mb-1">
                                        <Card class="w-100">
                                            <template #content>
                                                <div class="d-flex d-between d-align-center">
                                                    <div class="w-30">
                                                        <div :style="
                                                                'background-size: cover;' +
                                                                'background-position: center top;' +
                                                                'background-image: url(' + this.baseUrl + 'storage/uploads/' + event.image.name + ');' +
                                                                'height: 10em;' +
                                                                'width: 80%;' +
                                                                'background-repeat: round;' +
                                                                'border-radius: 0.5em'
                                                        "></div>
                                                    </div>
                                                    <div class="w-70">
                                                        <div class="d-flex d-between">
                                                            <section class="w-40">
                                                                <p>
                                                                    <strong>{{ event.name }}</strong>
                                                                </p>
                                                                <small>{{ event.start_date }} {{ event.start_time }}</small><br />
                                                                <small>{{ event.expiration_date }} {{ event.expiration_time }}</small>
                                                            </section>
                                                            <section>
                                                                <p>
                                                                    <strong>Статус:</strong>
                                                                </p>
                                                                <InlineMessage severity="warn">В архиве</InlineMessage>
                                                            </section>
                                                            <section>
                                                                <p>Участников: {{ this.participants.length > 0 ? this.participants.length : 0 }}</p>
                                                                <div class="mb-1">
                                                                    <a :href="this.baseUrl + this.route.EVENT + '?id=' + event.id">
                                                                        <Button label="Подробнее" severity="secondary" outlined class="w-100" />
                                                                    </a>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.UPDATE + '?id=' + event.id">
                                                                        <Button label="Редактировать" severity="primary" outlined class="w-100" />
                                                                    </a>
                                                                </div>
                                                                <div>
                                                                    <Button label="Возобновить"
                                                                            severity="primary"
                                                                            outlined
                                                                            class="w-100"
                                                                            @click="this.removeEventToArchive(event.key)" />
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </Card>
                                    </section>
                                    <div class="w-100">
                                        <Paginator :rows="10" :totalRecords="120"></Paginator>
                                    </div>
                                </section>
                                <section v-else class="d-flex d-center">
                                    <InlineMessage severity="warn" class="w-70">Данных нет</InlineMessage>
                                </section>
                            </TabPanel>
                        </TabView>
                    </template>
                </Card>
            </section>
            <!-- ATHLETE VIEW -->
            <section v-if="this.user.role === 'athlete'" class="mb-5 d-flex d-between d-flex-wrap">
                <Card v-for="event in this.events[RESPONSE.data]"
                      v-key="event"
                      style="overflow: hidden"
                      class="mb-3 w-30">
                    <template #header>
                        <div style="
                                background-size: cover;
                                background-position: top;
                                background-image: url(https://shakasports.com/images/1714108924_Khabarovsk%20Open%202024.jpg);
                                height: 14em;
                                width: 100%;
                                background-repeat: no-repeat;
                        ">
                            <InlineMessage severity="success">Активно</InlineMessage>
                        </div>
                    </template>
                    <template #title>{{event.name }}</template>
                    <template #content>
<!--                        <p class="m-0"> {{ this.short(event.description, 130) }}</p>-->
                    </template>
                    <template #footer>
                        <span>Даты проведения:</span>
                        <div class="d-flex d-between">
                            <strong><i class="pi pi-calendar-plus"></i> {{ event.start_date }} <i class="pi pi-stopwatch"></i> {{ event.start_time }}</strong>
                        </div>
                        <div class="flex gap-3 mt-2">
                            <br>
                            <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.HISTORY + '?key=' + event.key">
                                <Button label="Подробнее" severity="secondary" outlined class="w-full" />
                            </a>
                        </div>
                    </template>
                </Card>
                <div class="w-100">
                    <Paginator :rows="10" :totalRecords="120"></Paginator>
                </div>
            </section>
        </div>
    </section>
</template>

<style scoped>
#table .p-card-body{
    padding: 0.7em!important;
}
</style>
