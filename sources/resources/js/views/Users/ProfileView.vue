<script>
import { BASE_URL, TOKEN, IDENTIFIER } from '../../constant';
import { getUser } from '../../api/UserRequest';
import { getRecordToEventsRequest } from '../../api/FilterRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Image from 'primevue/image';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';


export default {
    data() {
        return {
            baseUrl: BASE_URL,
            id: null,
            user: null,
            participantList: null,
            token: null,
            events: null
        };
    },
    components: {
        Card: Card,
        InputText: InputText,
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
        userReadToEvent: function ()
        {
            getRecordToEventsRequest(`user_id:${window.$cookies.get(IDENTIFIER)}`, 'after')
                .then((response) => { this.events = response.data.result.original; })
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
        }
    },
    beforeMount() {
        this.tokenRead();
        this.userIdentifier();
        this.userReadToEvent();
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
<!--            <Image src="images/athlete_default_avatar.png" width="250" />-->
            <div class="mt-06">
                <h2>
                    <strong>{{ this.user.first_name }} {{ this.user.last_name }}</strong> <br>
                    <small>{{ this.user.first_name_eng }} {{ this.user.last_name_eng }}</small>
                </h2>
            </div>
            <div class="mt-06">
                <a :href="this.baseUrl + 'profile/settings'">
                    <Button type="button" label="Настройки" class="w-50" severity="primary"/>
                </a>
            </div>
            <div class="mt-06">
                <Button type="button" label="Выход" class="w-50" severity="danger" @click="logout"/>
            </div>
        </div>
        <div class="w-70">
            <section id="table">
                <Card>
                    <template #content>
                        <div class="d-flex d-between d-align-center">
                            <h3>Менроприятия в которых вы участвуете:</h3>
                            <a :href="this.baseUrl + 'event/history'">
                                <Button label="Посмотреть все" severity="link" />
                            </a>
                        </div>
                    </template>
                </Card>
            </section>
            <section class="mt-5 mb-5 d-flex d-between d-flex-wrap">
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
