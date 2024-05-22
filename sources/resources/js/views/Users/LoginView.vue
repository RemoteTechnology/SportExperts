<script>
import { baseUrl } from '../../constant';
import { authorizationRequest } from '../../api/AuthRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';

export default {
    data() {
        return {
            messageError: null,
            baseUrl: baseUrl,
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
        authorizationRequest: function() {
            authorizationRequest({email: this.email, password: this.password})
                .then((response) => {
                    try {
                        window.$cookies.set('user_token', `Bearer ${response.data.result.original.token}`);
                        window. location = baseUrl + 'profile';
                    }
                    catch (TypeError)
                    {
                        this.messageError = 'Не правильный логин или пароль';
                    }
                })
                .catch(function (error) { console.log(error) })
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
                <a :href="baseUrl + 'registration'">
                    <Button label="Регистрация" severity="info" link />
                </a>
            </div>
            <form>
                <div class="form-block">
                    <label for="#">Введите логин</label>
                    <InputText v-model="email" class="w-100"/>
                </div>
                <div class="form-block">
                    <label for="#">Введите пароль</label>
                    <InputText v-model="password" class="w-100"/>
                </div>
                <div class="form-block d-flex d-between">
                    <a :href="baseUrl + 'recovery'">
                        <Button label="Забыли пароль?" severity="info" link />
                    </a>
                    <Button label="Войти" class="w-30" severity="success" @click="authorizationRequest" />
                </div>
            </form>
        </section>
    </section>
</template>
