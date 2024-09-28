<script>
    import AppParticipantInfoModalComponent from "./modals/AppParticipantInfoModalComponent.vue";
    import LeaderLine from "leader-line-vue";
    import Card from "primevue/card";
    import {tournamentReadRequest} from "../api/TournamentRequest";
    import {createLogOptionRequest} from "../api/CreateLogOptionRequest";
    import {MESSAGES} from "../constant";
    import AppParticipantsCardComponent from "./cards/AppParticipantsCardComponent.vue";

    export default {
        data() {
            return {
                eventKey: null
            }
        },
        props: {
            eventKeyProps: String,
            tournamentValuesProps: Object
        },
        components: {
            AppParticipantsCardComponent,
            AppParticipantInfoModalComponent,
            Card,
        },
        methods: {
            addMessageError: async function (data) { await this.$emit('messageErrorEmit', data); },
            async readTournament() {
                const attributes = {
                    event_key: this.eventKey,
                };
                await tournamentReadRequest(attributes)
                    .then(async (response) => {
                        console.log(response);
                        const data = await response.data.result.original;
                        this.values = await data.attributes;
                    })
                    .catch(async (error) => {
                        console.log(error);
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'tournamentReadRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        await this.$emit('messageErrorEmit', MESSAGES.ERROR_ERROR);
                    });
            },
            tyingAthlete() {
                for (let key in this.values.attributes)
                {
                    this.values.attributes[key].forEach(async (value) => {
                        await value.tournament_values.forEach((participant) => {
                            try {
                                let line = new LeaderLine.setLine(
                                    document.getElementById(participant.participants_A.key),
                                    document.getElementById(participant.participants_B.key),
                                    {
                                        color: "#5c5c5c",
                                        path: "arc",
                                        endPlug: "behind",
                                    }
                                );
                                line.setOptions({ startSocket: 'top', endSocket: 'right' });
                            } catch (e)
                            {
                                console.log('Message Error: ' + e.message)
                            }
                        });
                    });
                }
            },
        },
        async mounted() {
            await this.readTournament();
            await this.$nextTick(() => {
                this.tyingAthlete();
            });
        },
        watch: {
            eventKeyProps: {
                handler(value) {
                    this.eventKey = value;
                },
                immediate: true,
                deep: true
            }
        }
    }
</script>

<template v-for="value in this.tournamentValuesProps">
    <section id="body-tournament">
        <Card class="mt-1">
            <template #content>
                <section id="athlete-card" class="d-flex d-between">
                    <span>{{ value.users[0].first_name }} {{ value.users[0].last_name }}</span>
                    <AppParticipantInfoModalComponent
                        :userIdProps="value.users[0].id"
                        :eventKeyProps="this.eventKeyProps"
                        @messageErrorEmit="addMessageError" />
                </section>
                <span class="flag" :id="value.participants_A.key"></span>
                <small>Команда</small>
            </template>
        </Card>
        <Card class="mt-1">
            <template #content v-if="value.users[1] !== null">
                <section id="athlete-card" class="d-flex d-between">
                    <span>{{ value.users[1].first_name }} {{ value.users[1].last_name }}</span>
                    <AppParticipantInfoModalComponent
                        :userIdProps="value.users[1].id"
                        :eventKeyProps="this.eventKeyProps"
                        @messageErrorEmit="addMessageError" />
                </section>
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
</template>
