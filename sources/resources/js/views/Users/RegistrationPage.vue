<script>
    import Button from 'primevue/button';
    import Message from 'primevue/message';
    import AppRegistrationFormComponent from "../../components/forms/AppRegistrationFormComponent.vue";
    import AppAlertComponent from "../../components/AppAlertComponent.vue";
    import AppWrapperComponent from "../../components/wrappers/AppWrapperComponent.vue";
    import AppPageTitleComponent from "../../components/AppPageTitleComponent.vue";
    import { ENDPOINTS } from "../../common/route/api";
    import { WEB_URL } from "../../common/route/web";
    import AppLoginFormComponent from "../../components/forms/AppLoginFormComponent.vue";

    export default {
        data() {
            return {
                urlKey: false,
                inviteUserId: null,
                eventId: null,
                pageTitle: 'Регистрация',
                subTitle: 'Вход',
                webUrl: WEB_URL,
                messageSuccess: null,
                messageError: null,
                route: ENDPOINTS,
            };
        },
        components: {
            AppLoginFormComponent,
            Button,
            Message,
            AppWrapperComponent,
            AppPageTitleComponent,
            AppRegistrationFormComponent,
            AppAlertComponent,
        },
        methods: {
            getUrl: function () {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.size > 0)
                {
                    this.invite_user_id = urlParams.get('invite_user_id');
                    this.event_id = urlParams.get('event_id');
                    this.urlKey = true;
                }
            },
            addMessageSuccess: function (data) { this.messageSuccess = data; },
            addMessageError: function (data) { this.messageError = data; }
        },
        beforeMount() {
            this.getUrl();
        }
    }
</script>

<template>
    <AppWrapperComponent>
        <AppAlertComponent
            :messageSuccess="this.messageSuccess"
            :messageError="this.messageError" />
        <AppPageTitleComponent
            v-if="!this.urlKey"
            :title="this.pageTitle"
            :subTitle="this.pageSubTitle"
            :baseUrl="this.webUrl"
            :endPoint="this.route.LOGIN" />
        <AppRegistrationFormComponent
            :eventId="this.eventId"
            :inviteUserId="this.inviteUserId"
            :urlKey="this.urlKey"
            @messageSuccessEmit="addMessageSuccess"
            @messageErrorEmit="addMessageError"/>
    </AppWrapperComponent>
</template>
