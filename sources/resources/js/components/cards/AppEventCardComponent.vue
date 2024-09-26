<script>
    import Button from 'primevue/button';
    import Card from "primevue/card";
    import { IDENTIFIER, MESSAGES } from "../../constant";
    import { recordUserToEventRequest } from "../../api/ParticipantRequest";
    import { createLogOptionRequest } from "../../api/CreateLogOptionRequest";
    import AppModalInvitesComponent from "../AppModalInvitesComponent.vue";
    import AppEventOptionsCardComponent from "./AppEventOptionsCardComponent.vue";
    import AppEventParticipantsCardComponent from "./AppEventParticipantsCardComponent.vue";

    export default {
        data() {
          return {
              currentDate: new Date(),
              dialog: false,
              eventId: null,
          };
        },
        props: {
            eventProps: Object,
            userProps: Object,
            eventIdProps: String,
        },
        components: {
            AppEventParticipantsCardComponent,
            AppEventOptionsCardComponent,
            AppModalInvitesComponent,
            Card,
            Button
        },
        methods: {
            formatDate: (inputDate) => {
                const [year, month, day] = inputDate.split('-');
                return `${day.padStart(2, '0')}.${month.padStart(2, '0')}.${year}`;
            },
            invited: async function ()
            {
                let attributes = {
                    event_id: this.eventIdProps,
                    user_id: this.user.id,
                    invited_user_id: window.$cookies.get(IDENTIFIER),
                    // team_key: null,
                };

                recordUserToEventRequest(attributes)
                    .then(async(response) => {
                        console.log(response);
                        const data = await response.data.result.original;
                        this.messageSuccess = await data.attributes ? MESSAGES.FORM_SUCCESS : MESSAGES.ERROR_ERROR;
                    })
                    .catch(async(error) => {
                        console.log(error);
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'recordUserToEventRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        this.messageError = MESSAGES.ERROR_ERROR;
                    });
            },
        },
        watch: {
            eventIdProps: {
                handler(value) {
                    this.eventId = value;
                },
                immediate: true,
                deep: true
            }
        }
    }
</script>

<template>
    <div class="w-50">
        <Card role="region">
            <template #header>
                <h2 class="text-center">{{ this.eventProps.name }}</h2>
            </template>
            <template #content>
                <div class="mb-1">
                    <h3>
                        <i class="pi pi-map-marker" style="color: #222"></i> <span>{{ this.eventProps.location }}</span>
                    </h3>
                </div>
                <div class="mb-1">
                    <h3>
                        <i class="pi pi-calendar-clock" style="color: #222"></i> <span>{{ this.formatDate(this.eventProps.start_date) }}</span>
                    </h3>
                </div>
                <div class="mb-1">
                    <h3>
                        <i class="pi pi-users" style="color: #222"></i> <span>{{ this.eventProps.participants.length }} участников</span>
                    </h3>
                </div>
                <div class="mb-1">
                    <br>
                    <AppModalInvitesComponent  v-if="this.userProps && this.userProps.role === 'admin'"
                                               :userProps="this.userProps"
                                               :eventIdProps="this.eventIdProps" />
                    <Button v-if="this.userProps && this.userProps.role === 'athlete'"
                            label="Записаться"
                            severity="primary"
                            class="w-100"
                            @click="this.invited" />
                </div>
            </template>
        </Card>
        <AppEventOptionsCardComponent :optionsProps="this.eventProps.options" />
        <AppEventParticipantsCardComponent :optionsProps="this.eventProps.participants" />
    </div>
</template>
