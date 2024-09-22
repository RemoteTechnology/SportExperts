<script>
import {
    BASE_URL,
    TOKEN,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS
} from '../../constant';
import { getTournamentTableToEvent } from '../../api/TournamentRequest';
import Message from 'primevue/message';
import Card from 'primevue/card';
import InputText from "primevue/inputtext";
import Button from "primevue/button";

export default {
    data() {
        return {
            route: ENDPOINTS,
            currentDate: new Date(),
            messageError: null,
            baseUrl: BASE_URL,
        };
    },
    components: {
        Card: Card,
        Message: Message,
    },
    methods: {

    }
};
</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-5">
            <section class="mt-1 mb-2" v-if="this.messageError !== null">
                <Message severity="error">{{ this.messageError }}</Message>
            </section>
            <div class="text-center">
                <h2>Настройки сетки</h2>
                <a :href="this.baseUrl + this.route.REGISTRATION">
                    <Button label="Регистрация" severity="info" link />
                </a>
            </div>
        </section>
    </section>

</template>
