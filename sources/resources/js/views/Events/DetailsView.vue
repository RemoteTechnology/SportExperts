<script>
import {BASE_URL, IDENTIFIER} from "../../constant";
import { getEventRequest } from '../../api/EventRequest';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Image from 'primevue/image';
import Card from 'primevue/card';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';

export default {
    data(){
        return {
            baseUrl: BASE_URL,
            eventId: null,
            event: null,
        };
    },
    components: {
        Button: Button,
        Message: Message,
        Image: Image,
        DataTable: DataTable,
        Card: Card,
        Column: Column,
        ColumnGroup: ColumnGroup
    },
    methods: {
        getUrl: function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            this.eventId = urlParams.get('id');
        },
        getEvent: function ()
        {
            getEventRequest({ id: this.eventId })
                .then((response) => { console.log(response); this.event = response.data.result.original; })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
        }
    },
    beforeMount() {
        this.getUrl();
        this.getEvent();
    }
}
</script>

<template>
    <section v-if="this.event != null" class="mt-5 mb-5">
        <section class="container d-flex d-between d-flex-wrap">
            <div class="w-50">
                <Image src="https://shakasports.com/images/1714108924_Khabarovsk%20Open%202024.jpg" :alt="this.event.name" />
                <div class="mt-3">
                    <h3>ИНФОРМАЦИЯ</h3>
                    <br>
                    <p style="
                        white-space: break-spaces;
                        line-height: 120%;
                        color: #323232;
                    ">{{ this.event.description }}</p>
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
                            <a :href="this.baseUrl">
                                <Button label="Записаться" severity="primary" class="w-100" />
                            </a>
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
