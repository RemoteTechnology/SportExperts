<script>
    import { BASE_URL, MESSAGES, ENDPOINTS } from '../../constant';
    import { createLogOptionRequest } from "../../api/CreateLogOptionRequest";
    import { getKeyEventRequest } from "../../api/EventRequest";
    import AppParticipantInfoModalComponent from "../../components/modals/AppParticipantInfoModalComponent.vue";
    import AppAlertComponent from "../../components/AppAlertComponent.vue";
    import AppTournamentStageComponent from "../../components/AppTournamentStageComponent.vue";
    import AppTournamentValuesComponent from "../../components/AppTournamentValuesComponent.vue";
    import AppTournamentInfoCardComponent from "../../components/cards/AppTournamentInfoCardComponent.vue";
    import {tournamentReadRequest} from "../../api/TournamentRequest";
    import AppParticipantsCardComponent from "../../components/cards/AppParticipantsCardComponent.vue";

    export default {
        data() {
            return {
                messageSuccess: null,
                messageError: null,
                baseUrl: BASE_URL,
                eventKey: '',
                event: null,
                user: null,
                values: null
            };
        },
        components: {
            AppParticipantsCardComponent,
            AppTournamentValuesComponent,
            AppTournamentStageComponent,
            AppAlertComponent,
            AppParticipantInfoModalComponent,
            AppTournamentInfoCardComponent,
        },
        methods: {
            addMessageSuccess: function (data) { this.messageSuccess = data; },
            addMessageError: function (data) { this.messageError = data; },
            getUrl() {
                const urlParams = new URLSearchParams(window.location.search);
                this.eventKey = urlParams.get('event');
            },
            getEvent: async function(eventKey) {
                const attributes = {
                    key: eventKey
                };
                await getKeyEventRequest(attributes)
                    .then(async (response) => {
                        console.log(response)
                        const data = await response.data.result.original;
                        this.event = await data.attributes;
                    })
                    .catch(async (error) => {
                        console.log(error)
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getKeyEventRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        this.messageError = MESSAGES.ERROR_ERROR;
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
                        // Сортировка "tournament_values", у кого нет пары смещаем в конец
                        for (let attributes in this.values) {
                            this.values[attributes][0].tournament_values.sort((a, b) => (a.participants_B === null) - (b.participants_B === null));
                        }
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
                        this.messageError = MESSAGES.ERROR_ERROR;
                    });
            },
        },
        async beforeMount() {
            await this.getUrl();
            await this.getEvent(this.eventKey);
            await this.readTournament();
        }
    };
</script>

<template>
    <!-- TODO: добавить админов, сделать им систему прав аля круд -->
    <section class="d-center">
        <section class="mt-5">
            <AppAlertComponent
                :messageSuccess="this.messageSuccess"
                :messageError="this.messageError" />
            <section v-if="this.event">
                <h2 class="mb-2 text-center">{{ this.event.name }}</h2>
            </section>
            <div class="d-flex d-between">
                <div class="w-30 d-flex d-end">
                    <AppTournamentInfoCardComponent
                        :eventKeyProps="this.eventKey"
                        @messageErrorEmit="addMessageError" />
                </div>
                <div class=" d-flex scroll-bottom"
                     style="
                         position: relative;
                         right: 2.5%;
                         width: 65vw;
                         height: 73vh;
                    ">
                   <div v-for="attribute in this.values" class="w-22e">
                        <template v-for="tournament in attribute" :key="tournament.id">
                            <AppTournamentStageComponent
                                :eventKeyProps="this.eventKey"
                                :tournamentProps="tournament"
                                @messageErrorEmit="addMessageError" />
                        </template>
                   </div>
                </div>
            </div>
        </section>
    </section>
</template>
