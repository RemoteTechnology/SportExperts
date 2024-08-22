<script>
import {
    BASE_URL,
    MESSAGES,
    ENDPOINTS
} from '../../constant';
import { tournamentReadRequest } from '../../api/TournamentRequest';
import Message from 'primevue/message';
import Card from 'primevue/card';
import LeaderLine from 'leader-line-vue';
import { createLogOptionRequest } from "../../api/CreateLogOptionRequest";

export default {
    data() {
        return {
            route: ENDPOINTS,
            currentDate: new Date(),
            messageError: null,
            baseUrl: BASE_URL,
            eventKey: '',
            tournamentDetails: null
        };
    },
    components: {
        Card,
        Message,
    },
    methods: {
        getUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            this.eventKey = urlParams.get('event');
        },
        async readTournament() {
            const attributes = {
                event_key: this.eventKey,
            };
            try {
                const response = await tournamentReadRequest(attributes);
                this.tournamentDetails = response.data.result.original;
            } catch (error) {
                createLogOptionRequest({
                    current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                    current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                    method: 'tournamentReadRequest',
                    status: error.code,
                    request_data: attributes.toString(),
                    message: error.message
                });
                this.messageError = MESSAGES.ERROR_ERROR;
            }
        },
        tyingAthlete() {
            if (this.tournamentDetails && this.tournamentDetails.values) {
                this.tournamentDetails.values.forEach((value) => {

                    if (
                        document.getElementById(value.participants_A.key) &&
                        document.getElementById(value.participants_B.key)
                    )
                    {
                        let line = new LeaderLine.setLine(
                            document.getElementById(value.participants_A.key),
                            document.getElementById(value.participants_B.key),
                            {
                                color: "#5c5c5c",
                                path: "arc",
                                endPlug: "behind",
                            }
                        );
                        line.setOptions({ startSocket: 'top', endSocket: 'right' });
                    } else {
                        console.error(`Not found for: ${value.participants_A.key} or ${value.participants_B.key}`);
                    }
                });
            }
        }
    },
    async mounted() {
        await this.getUrl();
        await this.readTournament();
        await this.$nextTick(() => {
            this.tyingAthlete();
        });
    }
};
</script>

<template>
        <section class="d-center">
            <section class="mt-5">
                <section class="mt-1 mb-2" v-if="this.messageError !== null">
                <Message severity="error">{{ this.messageError }}</Message>
            </section>
            <h2 class="text-center mb-2">{{ this.tournamentDetails.tournament.event.name }}</h2>
            <div class="d-flex">
                <div v-if="
                        this.tournamentDetails !== null &&
                        Object.keys(this.tournamentDetails).includes('tournament') &&
                        Object.keys(this.tournamentDetails.tournament).includes('event')
                    " class="w-100">
                    <section v-if="
                                this.tournamentDetails !== null &&
                                Object.keys(this.tournamentDetails).includes('values') &&
                                this.tournamentDetails.values.length > 0
                            "
                            id="tid"
                            class="d-flex d-between d-align-center">
                        <section v-for="value in this.tournamentDetails.values"  style="width: 150%;">
                            <section>
                                <Card class="mt-1">
                                    <template #content>
                                        <span>{{ value.users[0].first_name }} {{ value.users[0].last_name }}</span><br />
                                        <span class="flag"  :id="value.participants_A.key"></span>
                                        <small>Команда</small>
                                    </template>
                                </Card>
                                <Card class="mt-1">
                                    <template #content v-if="value.users[1] !== null">
                                        <span>{{ value.users[1].first_name }} {{ value.users[1].last_name }}</span><br />
                                        <span class="flag" :id="value.participants_B.key"></span>
                                        <small>Команда</small>
                                    </template>
                                    <template #content v-else>
                                        <span style="color: #bd3131">
                                            <i>(Нет соперника)</i>
                                        </span>
                                    </template>
                                </Card>
                            </section>
                        </section>
                    </section>
                </div>
            </div>
        </section>
    </section>
</template>
