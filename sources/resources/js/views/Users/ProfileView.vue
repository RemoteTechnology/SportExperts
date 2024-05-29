<script>
import { BASE_URL, TOKEN, IDENTIFIER } from '../../constant';
import { getUser } from '../../api/UserRequest';
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


export default {
    data() {
        return {
            baseUrl: BASE_URL,
            id: null,
            user: null,
            participants: null,
            token: null,
            events: null,
            first: 0,
            myUsers: [
                {first_name: 'Серёня', last_name: 'Лебеженский', age: 20},
                {first_name: 'Джабраил', last_name: 'Бургамедович', age: 18},
                {first_name: 'Оля', last_name: 'Рукавкина', age: 19},
                {first_name: 'Вячеслав', last_name: 'Божественный', age: 20},
                {first_name: 'Серёня', last_name: 'Лебеженский', age: 20},
                {first_name: 'Джабраил', last_name: 'Бургамедович', age: 18},
                {first_name: 'Оля', last_name: 'Рукавкина', age: 19},
                {first_name: 'Вячеслав', last_name: 'Божественный', age: 20},
                {first_name: 'Серёня', last_name: 'Лебеженский', age: 20},
                {first_name: 'Джабраил', last_name: 'Бургамедович', age: 18},
                {first_name: 'Оля', last_name: 'Рукавкина', age: 19},
            ]
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
    },
    methods: {
        short: (str, maxlen) => str.length <= maxlen ? str : str.slice(0, maxlen) + '...',
        userIdentifier: function ()
        {
            getUser({id: window.$cookies.get(IDENTIFIER)})
                .then((response) => { this.user = response.data.result.original; })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
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
            getRecordToEventsRequest(`user_id:${window.$cookies.get(IDENTIFIER)}`, 'after')
                .then((response) => { this.events = response.data.result.original; })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
        },
        getEventOwner: function ()
        {
            getEventOwnerRequest(`user_id:${window.$cookies.get(IDENTIFIER)}`)
                .then((response) => { this.events = response.data.result.original; })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
        },
        getParticipants: function ()
        {
            getEventParticipantRequest(`invited_user_id:${window.$cookies.get(IDENTIFIER)}`)
                .then((response) => { console.log(response);this.participants = response.data.result.original; })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
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
                                    <a :href="this.baseUrl + 'profile/settings'">
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
                <Card>
                    <template #header>
                        <div class="d-flex d-center">
                            <h4>Ваши спортсмены:</h4>
                        </div>
                    </template>
                    <template #content>
                        <DataTable :value="this.participants.data">
                            <Column header="">
                                <template #body>
                                    <Image src="images/athlete_default_avatar.png" width="30" />
                                </template>
                            </Column>
                            <Column field="first_name" header="Имя"></Column>
                            <Column field="last_name" header="Фамилия"></Column>
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
                <section class="mb-2 d-flex d-end">
                    <div class="w-50">
                        <section v-if="this.user.role === 'admin'">
                            <h3 class="mb-3">Спортивные события которые вы создали</h3>
                        </section>
                    </div>
                    <div class="w-50">
                        <Paginator :rows="10" :totalRecords="120"></Paginator>
                    </div>
                </section>
                <section v-for="event in this.events['data']" class="mt-1 mb-1">
                    <Card class="w-100">
                        <template #content>
                            <div class="d-flex d-between">
                                <div class="w-30">
                                    <div style="
                                        background-size: cover;
                                        background-position: center top;
                                        background-image: url(https://shakasports.com/images/1714108924_Khabarovsk%20Open%202024.jpg);
                                        height: 10em;
                                        width: 80%;
                                        background-repeat: round;
                                "></div>
                                </div>
                                <div class="w-70">
                                    <div class="d-flex d-between">
                                        <section>
                                            <p>
                                                <strong>{{ event.name }}</strong>
                                            </p>
                                            <small>{{ event.start_date }} {{ event.start_time }}</small><br />
                                            <small>{{ event.expiration_date }} {{ event.expiration_time }}</small>
                                        </section>
                                        <section>
                                            <p>Участников: 16</p>
                                            <a :href="this.baseUrl">
                                                <Button label="Подробнее" severity="secondary" outlined class="w-full" />
                                            </a>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Card>
                </section>
            </section>
            <!-- ATHLETE VIEW -->
            <section v-if="this.user.role === 'athlete'"
                     class="mt-5 mb-5 d-flex d-between d-flex-wrap">
                <Card v-for="event in this.events['data']"
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
                        "></div>
                    </template>
                    <template #title>{{event.name }}</template>
                    <template #content>
                        <p class="m-0"> {{ this.short(event.description, 130) }}</p>
                    </template>
                    <template #footer>
                        <span>Даты проведения:</span>
                        <div class="d-flex d-between">
                            <strong><i class="pi pi-calendar-plus"></i> {{ event.start_date }} <i class="pi pi-stopwatch"></i> {{ event.start_time }}</strong>
                        </div>
                        <div class="flex gap-3 mt-2">
                            <br>
                            <a :href="this.baseUrl + 'event/history?key=' + event.key">
                                <Button label="Подробнее" severity="secondary" outlined class="w-full" />
                            </a>
                        </div>
                    </template>
                </Card>
            </section>
        </div>
    </section>
</template>

<style scoped>
#table .p-card-body{
    padding: 0.7em!important;
}
</style>
