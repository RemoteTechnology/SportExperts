<script>
import {
    BASE_URL,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS,
    RESPONSE
} from "../../constant";
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import InputMask from 'primevue/inputmask';
import FloatLabel from 'primevue/floatlabel';
import Message from 'primevue/message';

export default {
    data()
    {
        return {
            messageSuccess: null,
            messageError: null,
            invites: [],
            participants: [],
        };
    },
    methods: {

    },
    components: {
        Card: Card,
        InputText: InputText,
        Button: Button,
        InputMask: InputMask,
        FloatLabel: FloatLabel,
        Message: Message,
    },
    beforeMount() {

    }
}
</script>

<template>
    <section class="d-flex d-center">
        <div class="text-center mt-3 mb-3">
            <h2>Спортсмены которых вы пригласили.</h2>
        </div>
    </section>
    <section class="mt-1 mb-2" v-if="this.messageSuccess">
        <Message severity="success">{{ this.messageSuccess }}</Message>
    </section>
    <section class="mt-1 mb-2" v-if="this.messageError">
        <Message severity="error">{{ this.messageError }}</Message>
    </section>
    <section class="d-flex d-between container">
        <div class="w-30">
            <section class="w-100">
                <Card>
                    <template #content></template>
                </Card>
            </section>
        </div>
    </section>
    <!--    <section v-if="this.events && this.events[this.response.data].length > 9" class="mt-5 mb-5">-->
    <!--    <Paginator :rows="9" :totalRecords="120"></Paginator>-->
    <!--    </section>-->
</template>
