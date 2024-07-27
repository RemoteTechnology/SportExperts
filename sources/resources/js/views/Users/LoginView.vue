<script>
import {
    BASE_URL,
    TOKEN,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS
} from '../../constant';
import { authorizationRequest } from '../../api/AuthRequest';
import { createLogOptionRequest } from '../../api/CreateLogOptionRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';

export default {
    data() {
        return {
            route: ENDPOINTS,
            currentDate: new Date(),
            messageError: null,
            baseUrl: BASE_URL,
            email: null,
            password: null,
        };
    },
    components: {
        Card: Card,
        InputText: InputText,
        Button: Button,
        Message: Message,
    },
    methods: {
        authorizationRequest: function () {
            let attributes = {email: this.email, password: this.password};
            authorizationRequest(attributes)
                .then((response) => {
                    try {
                        window.$cookies.set(TOKEN, response.data.result.original.token);
                        window.$cookies.set(IDENTIFIER, response.data.result.original.user.id);
                        window.location = this.baseUrl + ENDPOINTS.PROFILE;
                    }
                    catch (TypeError)
                    {
                        this.messageError = MESSAGES.LOGIN_ERROR;
                    }
                })
                .catch((error) => {
                    createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'authorizationRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    })
                })
        },
    }
}
</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-5">
            <section class="mt-1 mb-2" v-if="this.messageError !== null">
                <Message severity="error">{{ this.messageError }}</Message>
            </section>
            <div class="text-center">
                <h2>Вход</h2>
                <a :href="this.baseUrl + this.route.REGISTRATION">
                    <Button label="Регистрация" severity="info" link />
                </a>
            </div>
            <form>
                <div class="form-block">
                    <label for="#">Введите логин</label>
                    <InputText type="email"
                               v-model="email"
                               class="w-100"/>
                </div>
                <div class="form-block">
                    <label for="#">Введите пароль</label>
                    <InputText type="password" v-model="password" class="w-100"/>
                </div>
                <div class="form-block d-flex d-between">
                    <a :href="this.baseUrl + this.route.RECOVERY">
                        <Button type="button" label="Забыли пароль?" severity="info" link />
                    </a>
                    <Button type="button" label="Войти"
                            class="w-30"
                            severity="success"
                            @click="authorizationRequest" />
                </div>
            </form>
        </section>
    </section>
</template>
