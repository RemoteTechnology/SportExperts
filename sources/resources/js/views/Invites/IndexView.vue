<script>
import {
    BASE_URL,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS,
    RESPONSE
} from "../../constant";
import { registrationRequest } from '../../api/UserRequest';
import { loggingRequest } from '../../api/LoggingRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import InputMask from 'primevue/inputmask';
import FloatLabel from 'primevue/floatlabel';
import Message from 'primevue/message';

export default {
    data() {
        return {
            baseUrl: BASE_URL,
            messageError: null,
            response: RESPONSE,
            route: ENDPOINTS,
            currentDate: new Date(),
        };
    },
    components: {
        Card: Card,
        InputText: InputText,
        Button: Button,
        InputMask: InputMask,
        FloatLabel: FloatLabel,
        Message: Message,
    },
    methods: {},
    beforeMount() {}
}
</script>

<template>

</template>
