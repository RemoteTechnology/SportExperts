<script>
import {BASE_URL, IDENTIFIER} from "../../constant";
import { getEventListRequest } from '../../api/EventRequest';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Paginator from 'primevue/paginator';

export default {
    data() {
      return {
          baseUrl: BASE_URL,
          events: null,
      };
    },
    components: {
        Card: Card,
        Button: Button,
        Paginator: Paginator,
    },
    methods: {
        short: (str, maxlen) => str.length <= maxlen ? str : str.slice(0, maxlen) + '...',
        eventList: function ()
        {
            getEventListRequest()
                .then((response) => { this.events = response.data.result.original; })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
        }
    },
    beforeMount() {
        this.eventList();
    }
}
</script>

<template>
    <section v-if="this.events" class="mt-5 mb-5">
        <section class="container d-flex d-between d-flex-wrap">
            <Card v-for="event in this.events['data']"
                  v-key="event"
                  style="overflow: hidden"
                  class="mb-3 w-22">
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
                            <Button label="Записаться" severity="secondary" outlined class="w-100" />
                        </a>
                    </div>
                </template>
            </Card>
        </section>
    </section>
    <section class="mt-5 mb-5">
        <Paginator :rows="10" :totalRecords="this.events['per_page']"></Paginator>
    </section>
</template>

