<script>
    import Card from "primevue/card";
    import AppTournamentValuesComponent from "./AppTournamentValuesComponent.vue";
    import AppParticipantsCardComponent from "./cards/AppParticipantsCardComponent.vue";

    export default {
        data() {
          return {
              eventKey: null
          };
        },
        props: {
            eventKeyProps: String,
            tournamentProps: Object
        },
        components: {
            AppParticipantsCardComponent,
            Card,
            AppTournamentValuesComponent
        },
        methods: {
            addMessageError: async function (data) { await this.$emit('messageErrorEmit', data); },
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

<template>
    <section id="tid" class="d-flex d-between d-align-center">
        <section style="width: 150%;">
            <section id="step-tournament">
                <Card class="mb-3">
                    <template #content>
                        <strong># {{ this.tournamentProps.stage }} ЭТАП</strong>
                    </template>
                </Card>
            </section>
            <AppTournamentValuesComponent
                :eventKeyProps="this.eventKeyProps"
                :tournamentValueProps="this.tournamentProps.tournament_values"
                @messageErrorEmit="addMessageError" />/>
        </section>
    </section>
</template>
