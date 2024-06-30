<script>
import {BASE_URL, ENDPOINTS, IDENTIFIER, MESSAGES, RESPONSE} from "../../constant";
import { getUser } from "../../api/UserRequest";
import { getRecordToEventsRequest } from '../../api/FilterRequest';
import OrganizationChart from 'primevue/organizationchart';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Message from 'primevue/message';
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
          tournament: []
      };
    },
    methods: {
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
    },
    components: {
        OrganizationChart: OrganizationChart,
        Card: Card,
        Button: Button,
        Message: Message,
        Paginator: Paginator
    },
    beforeMount() {
        this.getUrl();
        this.userIdentifier();
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
    <!--
        Для отрисовки турнирной сетки использовать:
        https://anseki.github.io/leader-line/
        и
        https://anseki.github.io/plain-draggable/
    -->
</template>

<style>
div.p-organizationchart-line-down{
    background: #000!important;
}
td{
    border-color: #000!important;
}
</style>
