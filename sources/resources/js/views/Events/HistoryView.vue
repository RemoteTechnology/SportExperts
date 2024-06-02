<script>
import {BASE_URL, ENDPOINTS, IDENTIFIER, MESSAGES, RESPONSE} from "../../constant";
import { getUser } from "../../api/UserRequest";
import { getRecordToEventsRequest } from '../../api/FilterRequest';
import OrganizationChart from 'primevue/organizationchart';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Paginator from 'primevue/paginator';
import {loggingRequest} from "../../api/LoggingRequest";

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
          messageError: null,
          messageSuccess: null,
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
            let attributes = {id: window.$cookies.get(IDENTIFIER)};
            getUser(attributes)
                .then((response) => { this.user = response.data.result.original; })
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
        eventDate: function ()
        {
            if (this.eventKey)
            {
                let attributes = `user_id:${this.eventKey}`;
                //TODO: посмотреть что не так с этим запросом
                getRecordToEventsRequest(attributes, 'after')
                    .then((response) => { this.events = response.data.result.original; })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getRecordToEventsRequest',
                            status: error.code,
                            request_data: attributes.toString() + ', mode:after',
                            message: error.message
                        });
                        this.messageError = MESSAGES.LOADING_ERROR;
                    });
            }
            else
            {
                let attributes = `user_id:${window.$cookies.get(IDENTIFIER)}`;
                    getRecordToEventsRequest(attributes, 'all', 28)
                    .then((response) => { this.events = response.data.result.original; })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getRecordToEventsRequest',
                            status: error.code,
                            request_data: attributes.toString() + ', mode:all, ' + 'limit:28',
                            message: error.message
                        });
                        this.messageError = MESSAGES.LOADING_ERROR;
                    });
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
    <section class="mt-1 mb-2" v-if="this.messageError">
        <Message severity="error">{{ this.messageError }}</Message>
    </section>
    <section class="mt-1 mb-2" v-if="this.messageSuccess">
        <Message severity="error">{{ this.messageSuccess }}</Message>
    </section>
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
            <Card v-for="event in this.events[RESPONSE.data]"
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
                        <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.HISTORY + '?key=' + event.key">
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
