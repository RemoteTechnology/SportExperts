<script>
import {
    BASE_URL,
    TOKEN,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS
} from '../../constant';
import { getTournamentTableToEvent } from '../../api/TournamentRequest';
import { LeaderLine } from 'leader-line';
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
            tournamentAdmin: [
                {id: 997, first_name: 'Китай на', last_name: 'Связи'},
                {id: 998, first_name: 'Миска', last_name: 'Рис'},
                {id: 999, first_name: 'Китаёза', last_name: 'Китаёзовна'},
            ],
            tournament: [
                [
                    {id: 1, key: '123', winner: {id: 2, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 1, first_name: 'Вячеслав', last_name: 'Миронов'}},
                    {id: 2, key: '321', winner: {id: 3, first_name: 'Дмитрий', last_name: 'Миронов'}, loser: {id: 15, first_name: 'Вячеслав', last_name: 'Ванюков'}},

                    {id: 3, key: '456', winner: {id: 4, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 8, first_name: 'Вячеслав', last_name: 'Миронов'}},
                    {id: 4, key: '456', winner: {id: 10, first_name: 'Дмитрий', last_name: 'Миронов'}, loser: {id: 9, first_name: 'Вячеслав', last_name: 'Ванюков'}},

                    {id: 5, key: '654', winner: {id: 17, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 18, first_name: 'Вячеслав', last_name: 'Миронов'}},
                    {id: 6, key: '789', winner: {id: 22, first_name: 'Дмитрий', last_name: 'Миронов'}, loser: {id: 106, first_name: 'Вячеслав', last_name: 'Ванюков'}},

                    {id: 7, key: '987', winner: {id: 112, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 101, first_name: 'Вячеслав', last_name: 'Миронов'}},
                    {id: 8, key: '911', winner: {id: 6, first_name: 'Дмитрий', last_name: 'Миронов'}, loser: {id: 102, first_name: 'Вячеслав', last_name: 'Ванюков'}},
                ],
                [
                    {id: 1, key: '123', winner: {id: 2, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 1, first_name: 'Вячеслав', last_name: 'Миронов'}},
                    {id: 3, key: '456', winner: {id: 4, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 8, first_name: 'Вячеслав', last_name: 'Миронов'}},

                    {id: 5, key: '654', winner: {id: 17, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 18, first_name: 'Вячеслав', last_name: 'Миронов'}},
                    {id: 7, key: '987', winner: {id: 112, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 101, first_name: 'Вячеслав', last_name: 'Миронов'}},
                ],
                [
                    {id: 3, key: '456', winner: {id: 4, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 8, first_name: 'Вячеслав', last_name: 'Миронов'}},
                    {id: 7, key: '987', winner: {id: 112, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 101, first_name: 'Вячеслав', last_name: 'Миронов'}},
                ],
                [
                    {id: 7, key: '987', winner: {id: 112, first_name: 'Дмитрий', last_name: 'Ванюков'}, loser: {id: 101, first_name: 'Вячеслав', last_name: 'Миронов'}},
                ]
            ]
        };
    },
    components: {
        Card: Card,
        Message: Message,
    },
    methods: {
        drawingTournamentGrid: function()
        {

        }
    },
    beforeUnmount() {
        this.drawingTournamentGrid();
    }
};
</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-5">
            <section class="mt-1 mb-2" v-if="this.messageError !== null">
                <Message severity="error">{{ this.messageError }}</Message>
            </section>
            <div class="d-flex">
                <div class="w-100">
                    <h2>Название события</h2>
                    <section id="tid" class="w-140 d-flex d-between d-align-center">
                        <section v-for="t_list in this.tournament" class="w-160">
                            <section v-for="athlete in t_list" class="w-90">
                                <Card class="mt-1">
                                    <template #content>{{ athlete.winner.first_name }} {{ athlete.winner.last_name }}</template>
                                </Card>
                                <Card class="mt-1">
                                    <template #content>{{ athlete.loser.first_name }} {{ athlete.loser.last_name }}</template>
                                </Card>
                            </section>
                        </section>
                    </section>
                </div>
            </div>
        </section>
    </section>

</template>
