<script>
import { baseUrl } from '../../constant';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

export default {
    data() {
        return {
            baseUrl: baseUrl,
            login: null,
            password: null,
        };
    },
    components: {
        Card: Card,
        InputText: InputText,
        Button: Button,
    }
}
</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-5">
            <div class="text-center">
                <h2>Вход</h2>
                <a :href="baseUrl + 'registration'">
                    <Button label="Регистрация" severity="info" link />
                </a>
            </div>
            <form>
                <div class="form-block">
                    <label for="#">Введите логин</label>
                    <InputText v-model="login" class="w-100"/>
                </div>
                <div class="form-block">
                    <label for="#">Введите пароль</label>
                    <InputText v-model="password" class="w-100"/>
                </div>
                <div class="form-block d-flex d-between">
                    <a :href="baseUrl + 'recovery'">
                        <Button label="Забыли пароль?" severity="info" link />
                    </a>
                    <Button label="Войти" class="w-30" severity="success" />
                </div>
            </form>
        </section>
    </section>
</template>
