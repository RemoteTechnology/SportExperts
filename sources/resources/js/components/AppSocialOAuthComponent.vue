<script>
    import Button from 'primevue/button';
    import {GOOGLE_CLIENT_ID, VK_CLIENT_ID, VK_CODE_VERIFIER, VK_STATE} from "../common/social";
    import {createLogOptionRequest} from "../api/CreateLogOptionRequest";
    import {MESSAGES} from "../common/messages";
    import {authorizationRequest} from "../api/AuthRequest";
    import {IDENTIFIER, TOKEN} from "../common/fields";
    import {ENDPOINTS} from "../common/route/api";

    export default {
        data() {
            return {
                currentDate: new Date(),
                user: null
            }
        },
        components: {
            Button
        },
        methods: {
            handleGoogleUserInfo: async function() {
                // TODO: вынести этот венигрет в .env
                const clientId = GOOGLE_CLIENT_ID;
                const redirectUri = 'http://localhost:8080/login';
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
                                        console.log(response);
                                        const attributes = {
                                            google_id: data.sub,
                                            first_name: data.given_name,
                                            first_name_eng: '-',
                                            last_name: data.family_name,
                                            last_name_eng: '-',
                                            email: data.email,
                                            role: 'admin',
                                        };
                                        await authorizationRequest(attributes)
                                            .then(async (response) => {
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
                        // Ошибка возникает при попытке доступа к окну на другом домене
                    }
                }, 1000);

            },
            handleVkUserInfo: async function() {
                const clientId = VK_CLIENT_ID;
                const redirectUri = 'http://localhost:8080/';

                const VKID = window.VKIDSDK;
                VKID.Config.init({
                    app: clientId,
                    redirectUrl: redirectUri,
                    state: VK_STATE,
                    codeVerifier: VK_CODE_VERIFIER,
                    scope: 'email phone',
                });

                const oauthList = new VKID.OAuthList();
                oauthList.on(VKID.OAuthListInternalEvents.LOGIN_SUCCESS, function (payload) {
                    console.log(payload);
                });
            }
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
    <section class="mb-1">
        <Button label="Войти через ВКонтакте"
                class="w-100"
                style="
                    background-color: rgb(0, 119, 255);
                    border-color: rgb(0, 119, 255);
                    color: rgb(255, 255, 255);
                "
                @click="this.handleVkUserInfo"/>
    </section>
</template>

