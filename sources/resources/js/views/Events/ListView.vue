<script>
import {
    BASE_URL,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS,
    RESPONSE
} from "../../constant";
import { getEventListRequest } from '../../api/EventRequest';
import { loggingRequest } from '../../api/LoggingRequest';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Paginator from 'primevue/paginator';
import InlineMessage from 'primevue/inlinemessage';
import {getUser} from "../../api/UserRequest";
import {getRecordToEventsRequest} from "../../api/FilterRequest";

export default {
    data() {
      return {
          response: RESPONSE,
          route: ENDPOINTS,
          baseUrl: BASE_URL,
          events: null,
          eventsToRead: null,
          user: null,
          noData: MESSAGES.NO_DATA,
          currentDate: new Date(),
      };
    },
    components: {
        Card: Card,
        Button: Button,
        Paginator: Paginator,
        InlineMessage: InlineMessage
    },
    methods: {
        formatDate: (inputDate) => {
            const [year, month, day] = inputDate.split('-');
            return `${day.padStart(2, '0')}.${month.padStart(2, '0')}.${year}`;
        },
        short: (str, maxlen) => str.length <= maxlen ? str : str.slice(0, maxlen) + '...',
        stripHtmlTags: function(html)
        {
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        },
        userIdentifier: async function ()
        {
            const userId = window.$cookies.get(IDENTIFIER);
            if (userId)
            {
                let attributes = {id: userId};
                await getUser(attributes)
                    .then((response) => { this.user = response.data.result.original; })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getUser',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        })
                    });
            }
        },
        userReadToEvent: async function ()
        {
            if (this.user.role === 'athlete')
            {
                let attributes = `user_id:${window.$cookies.get(IDENTIFIER)}`;
                await getRecordToEventsRequest(attributes, 'after')
                    .then((response) => { console.log(response); this.eventsToRead = response.data.result.original; })
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
            }
        },
        eventList: async function ()
        {
            await getEventListRequest()
                .then((response) => { console.log(response); this.events = response.data.result.original; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getUser',
                        status: error.code,
                        request_data: '',
                        message: error.message
                    })
                });
        }
    },
    async beforeMount() {
        await this.userIdentifier();
        await this.eventList();
        await this.userReadToEvent();
    }
}
</script>

<template>
    <section v-if="this.events && this.events[this.response.data].length > 0" class="mt-5 mb-5">
        <section class="container d-flex d-between d-flex-wrap">
            <Card v-for="event in this.events[this.response.data]"
                  v-key="event"
                  style="overflow: hidden"
                  class="mb-3 w-22">
                <template #header>
                    <div :style="
                            'background-size: cover;' +
                            'background-position: top;' +
                            'background-image: url(' + this.baseUrl + 'storage/uploads/' + event.image.name + ');' +
                            'height: 14em;' +
                            'width: 100%;' +
                            'background-repeat: no-repeat;'
                    "></div>
                </template>
                <template #title>{{event.name }}</template>
                <template #content>
<!--                    <p class="m-0"> {{ this.stripHtmlTags(this.short(event.description, 130)) }}</p>-->
                </template>
                <template #footer>
                    <span>Даты проведения:</span>
                    <div class="d-flex d-between">
                        <strong>
                            <div>
                                <i class="pi pi-calendar-plus" style="
                                    font-weight: bold;
                                    color: #4aa81f;
                                "></i> {{ this.formatDate(event.start_date) }}
                            </div>
                            <div><i class="pi pi-stopwatch" style="
                                    font-weight: bold;
                                    color: #1f41a8;
                                "></i> {{ event.start_time.slice(0, -3) }}</div>
                        </strong>
                    </div>
                    <div v-for="eventParticipant in this.eventsToRead" class="flex gap-3 mt-2">
                        <a v-if="eventParticipant.key !== event.key" :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.HISTORY + '?key=' + event.key">
                            <Button label="Вы записаны"
                                    icon="pi pi-check"
                                    severity="link"
                                    class="w-100" />
                        </a>
                        <a v-else
                           :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.DETAIL + '?id=' + event.id">
                            <Button label="Записаться"
                                    severity="secondary"
                                    outlined
                                    class="w-100" />
                        </a>
                        <br>
                    </div>
                </template>
            </Card>
        </section>
    </section>
    <section v-else class="d-flex d-center">
        <InlineMessage severity="info" class="w-50 mt-5">{{ this.noData }}</InlineMessage>
    </section>
<!--    <section v-if="this.events && this.events[this.response.data].length > 9" class="mt-5 mb-5">-->
<!--    <Paginator :rows="9" :totalRecords="120"></Paginator>-->
<!--    </section>-->
</template>

