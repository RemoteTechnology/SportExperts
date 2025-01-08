<script>
    import Button from 'primevue/button';
    import {GOOGLE_CLIENT_ID, VK_CLIENT_ID, VK_CODE_VERIFIER, VK_STATE} from "../common/social";
    import {createLogOptionRequest} from "../api/CreateLogOptionRequest";
    import {MESSAGES} from "../common/messages";
    import {authorizationGoogleRequest} from "../api/AuthRequest";
    import {IDENTIFIER, TOKEN} from "../common/fields";
    import {ENDPOINTS} from "../common/route/api";
    import {WEB_URL} from "../common/route/web";
    import {getVkUser} from "../api/VkApiRequest";

    export default {
        data() {
            return {
                currentDate: new Date(),
                user: null
            }
        },
        props: {
            baseUrl: String,
        },
        components: {
            Button
        },
        mounted() {
            this.handleVkUserInfo();
        },
        methods: {
            handleGoogleUserInfo: async function() {
                // TODO: вынести этот венигрет в .env
                const clientId = GOOGLE_CLIENT_ID;
                const redirectUri = WEB_URL + 'login';
                const scope = 'profile email';
                const responseType = 'token';
                const url = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${clientId}&redirect_uri=${redirectUri}&response_type=${responseType}&scope=${scope}`;
                const authWindow = window.open(url, 'GoogleAuth', 'width=500,height=600');

                const checkAuthWindow = setInterval(() => {
                    try {
                        if (authWindow.closed) {
                            clearInterval(checkAuthWindow);
                            return;
                        }

                        const urlHash = authWindow.location.hash;
                        if (urlHash) {
                            const token = new URLSearchParams(urlHash.substring(1)).get('access_token');

                            if (token) {
                                authWindow.close();
                                clearInterval(checkAuthWindow);
                                axios.get('https://www.googleapis.com/oauth2/v3/userinfo', {
                                    headers: {
                                        Authorization: `Bearer ${token}`,
                                    }
                                })
                                    .then(async (response) => {
                                        const data = response.data;
                                        const attributes = {
                                            google_id: data.sub,
                                            first_name: data.given_name,
                                            first_name_eng: '-',
                                            last_name: data.family_name,
                                            last_name_eng: '-',
                                            email: data.email,
                                            role: 'admin',
                                        };
                                        console.log(attributes)
                                        await authorizationGoogleRequest(attributes)
                                            .then(async (response) => {
                                                console.log(response)
                                                if ('error' in response.data) {
                                                    this.isValid(response.data.error.data);
                                                    return;
                                                }
                                                try {
                                                    const data = response.data.result.original;
                                                    const attributes = data.attributes;
                                                    await window.$cookies.set(TOKEN, attributes.token);
                                                    await window.$cookies.set(IDENTIFIER, attributes.user.id);
                                                    window.location = this.baseUrl + ENDPOINTS.PROFILE;
                                                }
                                                catch (TypeError)
                                                {
                                                    await this.$emit('messageErrorEmit', MESSAGES.LOGIN_ERROR);
                                                }
                                            })
                                            .catch(async (error) => {
                                                await createLogOptionRequest({
                                                    current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                                    current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                                    method: 'authorizationRequest',
                                                    status: error.code,
                                                    request_data: attributes.toString(),
                                                    message: error.message
                                                });
                                                await this.$emit('messageErrorEmit', MESSAGES.NO_VALID_DATA);
                                            })

                                    })
                                    .catch(async (error) => {
                                        await createLogOptionRequest({
                                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                            method: 'handleGoogleUserInfo',
                                            status: error.code,
                                            request_data: 'No data',
                                            message: error.message
                                        });
                                        await this.$emit('messageErrorEmit', MESSAGES.NO_VALID_DATA);
                                    });

                            }
                        }
                    } catch (e) {
                    }
                }, 1000);

            },
            handleVkUserInfo: async function () {
                const clientId = VK_CLIENT_ID;
                const redirectUri = 'http://localhost/login'; //WEB_URL + 'login';
                const VKID = window.VKIDSDK;

                VKID.Config.init({
                    app: clientId,
                    redirectUrl: redirectUri,
                    responseMode: VKID.ConfigResponseMode.Callback,
                    source: VKID.ConfigSource.LOWCODE,
                    scope: 'email',
                });

                const oneTap = new VKID.OneTap();

                oneTap
                    .render({
                        container: this.$refs.container,
                        fastAuthEnabled: false,
                        showAlternativeLogin: true,
                        styles: {
                            borderRadius: 6,
                        },
                    })
                    .on(VKID.WidgetEvents.ERROR, this.vkidOnError.bind(this))
                    .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, (payload) => {
                        const code = payload.code;
                        const deviceId = payload.device_id;

                        VKID.Auth.exchangeCode(code, deviceId)
                            .then((data) => {
                                this.vkidOnSuccess(data);
                            })
                            .catch((error) => {
                                this.vkidOnError(error);
                            });
                    });
            },
             vkidOnSuccess(data) {
                console.log(data)
                getVkUser(data.user_id, data.access_token)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            },
            vkidOnError(error) {
                console.error('Ошибка:', error);
            },
        }
    }
</script>

<template>
    <div class="mt-3"></div>
    <section class="mb-1">
        <Button icon="pi pi-google"
                label="Войти через Google аккаунт"
                class="w-100"
                style="
                    background-color: #ed572d;
                    border-color: #ed572d;
                    color: #fff;
                "
                @click="this.handleGoogleUserInfo"/>
    </section>
    <section ref="container" class="mb-1"><!-- Тут Вк кнопка --></section>
</template>

