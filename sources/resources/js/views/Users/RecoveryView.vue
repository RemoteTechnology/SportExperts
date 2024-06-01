<script>
import { BASE_URL } from '../../constant';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

export default {
    data() {
        return {
            baseUrl: BASE_URL,
            email: null,
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
                <h2>Восстановление пароля</h2>
                <p>Укажите адрес электронной почты, мы на него отправим временный пароль.</p>
            </div>
            <form>
                <div class="form-block">
                    <label for="#">Введите E-mail</label>
                    <InputText type="email" v-model="email" class="w-100" />
                </div>
                <div class="form-block d-flex d-between">
                    <Button type="button" label="Отправить письмо" class="w-30" severity="success" />
                </div>
            </form>
        </section>
    </section>
</template>
