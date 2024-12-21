<script>
    import AppAlertComponent from "../../components/AppAlertComponent.vue";
    import AppLoginFormComponent from "../../components/forms/AppLoginFormComponent.vue";
    import AppPageTitleComponent from "../../components/AppPageTitleComponent.vue";
    import AppWrapperComponent from "../../components/wrappers/AppWrapperComponent.vue";
    import { API_URL, ENDPOINTS } from "../../common/route/api";
    import { WEB_URL } from "../../common/route/web";
    import AppSocialOAuthComponent from "../../components/AppSocialOAuthComponent.vue";
    import {activateUserRequest} from "../../api/UserRequest";
    import {createLogOptionRequest} from "../../api/CreateLogOptionRequest";

    export default {
        data() {
            return {
                apiUrl: API_URL,
                webUrl: WEB_URL,
                route: ENDPOINTS,
                messageSuccess: null,
                messageError: null,
                pageTitle: 'Вход',
                pageSubTitle: 'Регистрация',
                activateKey: null
            };
        },
        components: {
            AppAlertComponent,
            AppLoginFormComponent,
            AppPageTitleComponent,
            AppWrapperComponent,
            AppSocialOAuthComponent
        },
        methods: {
            getUrl: function () {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.size > 0)
                {
                    this.activateKey = urlParams.get('activate');
                    this.activateAccount();
                }
            },
            activateAccount: async function() {
                const attributes = {
                    key: this.activateKey
                };
                await activateUserRequest(attributes)
                    .then(async (response) => {
                        const data = response.data.result.original;
                        if (data.attributes.status === 'Обработан'){
                            this.addMessageSuccess(data.attributes.message);
                        }
                        this.addMessageError(data.attributes.message);
                    })
                    .catch(async (error) => {
                        this.addMessageError('Ошибка активации аккаунта!');
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getUserRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                    })
            },
            addMessageSuccess: function (data) { this.messageSuccess = data; },
            addMessageError: function (data) { this.messageError = data; },
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
            :title="this.pageTitle"
            :subTitle="this.pageSubTitle"
            :baseUrl="this.webUrl"
            :endPoint="this.route.REGISTRATION" />
       <AppLoginFormComponent
            :messageError="this.messageError"
            :baseUrl="this.webUrl"
            :endPoint="this.route.RECOVERY"
            @messageErrorEmit="addMessageError"/>
       <AppSocialOAuthComponent />
    </AppWrapperComponent>
</template>
