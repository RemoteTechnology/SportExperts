<script>
    import {getFreeParticipantsRequest, tournamentValueCreateRequest} from "../../api/TournamentValueRequest";
    import {createLogOptionRequest} from "../../api/CreateLogOptionRequest";
    import {MESSAGES} from "../../constant";
    import {getParticipantsToEventRequest} from "../../api/FilterRequest";
    import LeaderLine from "leader-line-vue";
    import {tournamentReadRequest} from "../../api/TournamentRequest";

    export default {
        data() {
            return {
                currentDate: new Date(),
                participantList: null,
                tournamentFree: null,
                values: null,
                eventKey: null,
            };
        },
        props: {
            eventKeyProps: String,
        },
        components: {

        },
        methods: {
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
            getListParticipants: async function(eventKey, mode='card') {
                const attributes = {
                    event_key: eventKey
                };
                await getParticipantsToEventRequest(attributes)
                    .then(async (response) => {
                        console.log(response);
                        const data = await response.data.result.original;
                        this.participantList = await data.attributes;
                    })
                    .catch(async (error) => {
                        console.log(error);
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getParticipantsToEventRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        await this.$emit('messageErrorEmit', MESSAGES.NO_DATA);
                    });
            },
            getFreeParticipantList: async function() {
                const attributes = {
                    event_key: this.eventKey
                };
                getFreeParticipantsRequest(attributes)
                    .then(async (response) => {
                        console.log(response);
                        const data = await response.data.result.original;
                        this.tournamentFree = await data.attributes;
                    })
                    .catch(async (error) => {
                        console.log(error);
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getFreeParticipantsRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        await this.$emit('messageErrorEmit', MESSAGES.NO_DATA);
                    });
            },
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
            createParticipantTournament(userId) {
                const attributes = {
                    event_key: this.eventKey,
                    user_id: userId,
                };
                tournamentValueCreateRequest(attributes)
                    .then(async (response) => {
                        console.log(response);
                        await this.getListParticipants(this.eventKey, 'page');
                        await this.readTournament();
                        await this.$nextTick(() => {
                            this.tyingAthlete();
                        });
                    })
                    .catch(async (error) => {
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'tournamentValueCreateRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                    });
            },
        },
        async beforeMount () {
            await this.getFreeParticipantList();
            await this.readTournament();
            await this.getListParticipants(this.eventKey, 'page');
        },
        watch: {
            eventKeyProps: {
                handler(value) {
                    this.eventKey = value;
                },
                immediate: true,
                deep: true
            },
        }
    }
</script>

<template>
    <Card class="mb-3 w-95 h-40">
        <template #content>
            <section v-if="this.participantList">
                <h3>Свободные спортсмены</h3>
                <br>
                <OrderList v-model="this.tournamentFree" listStyle="height:auto" dataKey="id">
                    <template #item="slotProps">
                        <section class="d-flex d-between d-align-center">
                            <section class="w-70">
                                <p>{{ slotProps.item.user.first_name }} {{ slotProps.item.user.last_name }}</p>
                                <small>Возраст: {{ slotProps.item.user.age }}
                                    <span v-for="option in slotProps.item.user.options" :key="option.name">
                                        <span v-if="option.name === 'Height'"> | Рост: {{ option.value }} см</span>
                                        <span v-if="option.name === 'Weight'"> | Вес: {{ option.value }} кг</span>
                                    </span>
                                </small>
                            </section>
                            <section class="w-30 d-flex d-end">
                                <Button icon="pi pi-arrow-right"
                                        aria-label="Success"
                                        @click="this.createParticipantTournament(slotProps.item.user.id)" />
                            </section>
                        </section>
                    </template>
                </OrderList>
            </section>
        </template>
    </Card>
</template>
