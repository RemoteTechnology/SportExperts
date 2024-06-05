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

export default {
    data() {
      return {
          response: RESPONSE,
          route: ENDPOINTS,
          baseUrl: BASE_URL,
          events: null,
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
        short: (str, maxlen) => str.length <= maxlen ? str : str.slice(0, maxlen) + '...',
        stripHtmlTags: function(html)
        {
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        },
        userIdentifier: function ()
        {
            const userId = window.$cookies.get(IDENTIFIER);
            if (userId)
            {
                let attributes = {id: userId};
                getUser(attributes)
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
        eventList: function ()
        {
            getEventListRequest()
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
    beforeMount() {
        this.userIdentifier();
        this.eventList();
    }
}
</script>

<template>
    <section v-if="this.events && this.events[this.response.data].length > 0" class="mt-5 mb-5">
        <section v-if="this.user && this.user.role === 'admin'" class="container mb-5">
            <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.CREATE">
                <Button label="Создать событие" severity="success" />
            </a>
        </section>
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
                    <p class="m-0"> {{ this.stripHtmlTags(this.short(event.description, 130)) }}</p>
                </template>
                <template #footer>
                    <span>Даты проведения:</span>
                    <div class="d-flex d-between">
                        <strong><i class="pi pi-calendar-plus"></i> {{ event.start_date }} <i class="pi pi-stopwatch"></i> {{ event.start_time }}</strong>
                    </div>
                    <div class="flex gap-3 mt-2">
                        <br>
                        <a :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.DETAIL + '?id=' + event.id">
                            <Button label="Записаться" severity="secondary" outlined class="w-100" />
                        </a>
                    </div>
                </template>
            </Card>
        </section>
    </section>
    <section v-else class="d-flex d-center">
        <InlineMessage severity="info" class="w-50 mt-5">{{ this.noData }}</InlineMessage>
    </section>
    <section v-if="this.events && this.events[this.response.data].length > 9" class="mt-5 mb-5">
        <Paginator :rows="10"></Paginator>
    </section>
</template>

