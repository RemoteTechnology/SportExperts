<script>
import {BASE_URL, IDENTIFIER} from "../../constant";
import {getUser} from "../../api/UserRequest";
import { getRecordToEventsRequest } from '../../api/FilterRequest';
import OrganizationChart from 'primevue/organizationchart';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Paginator from 'primevue/paginator';

export default {
    data() {
      return {
          baseUrl: BASE_URL,
          eventKey: null,
          user: null,
          events: null,
          tournament: {
              label: 'Argentina',
              children: [
                  {
                      label: 'Argentina',
                      children: [
                          {
                              label: 'Argentina'
                          },
                          {
                              label: 'Croatia'
                          }
                      ]
                  },
                  {
                      label: 'France',
                      children: [
                          {
                              label: 'France'
                          },
                          {
                              label: 'Morocco'
                          }
                      ]
                  }
              ]
          }
      };
    },
    methods: {
        short: (str, maxlen) => str.length <= maxlen ? str : str.slice(0, maxlen) + '...',
        getUrl: function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            this.eventKey = urlParams.get('key');
        },
        userIdentifier: function ()
        {
            getUser({id: window.$cookies.get(IDENTIFIER)})
                .then((response) => { this.user = response.data.result.original; })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
        },
        eventDate: function ()
        {
            if (this.eventKey)
            {
                //TODO: посмотреть что не так с этим запросом
                getRecordToEventsRequest(`user_id:${this.eventKey}`, 'after')
                    .then((response) => { this.events = response.data.result.original; })
                    .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
            }
            else
            {
                getRecordToEventsRequest(`user_id:${window.$cookies.get(IDENTIFIER)}`, 'all', 28)
                    .then((response) => { this.events = response.data.result.original; })
                    .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
            }
        }
    },
    components: {
        OrganizationChart: OrganizationChart,
        Card: Card,
        Button: Button,
        Paginator: Paginator
    },
    beforeMount() {
        this.getUrl();
        this.userIdentifier();
        this.eventDate();
    }
}
</script>

<template>
    <section v-if="eventKey" class="mt-5 mb-5">
        <OrganizationChart :value="this.tournament">
            <template #default="slotProps">
                <p>Команда: Витязи</p>
                <p>Спортсмен: Миронов Вячеслав</p>
            <!-- <span>{{ slotProps.node.label }}</span> -->
            </template>
        </OrganizationChart>
    </section>
    <section v-else class="mt-5 mb-5">
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
                            <Button label="Подробнее" severity="secondary" outlined class="w-100" />
                        </a>
                    </div>
                </template>
            </Card>
        </section>
        <Paginator :rows="10" :totalRecords="this.events['per_page']"></Paginator>
    </section>
</template>

<style>
div.p-organizationchart-line-down{
    background: #000!important;
}
td{
    border-color: #000!important;
}
</style>
