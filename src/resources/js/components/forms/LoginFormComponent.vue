<template>
    <form>
        <AlertErrorComponent
            v-if="alert != null && alert.type === 'Error'"
            v-bind:message="alert.message" />
        <div class="mb-3">
            <label for="exampleInputEmail" class="form-label">Адрес электронной почты</label>
            <input type="email"
                   class="form-control"
                   v-model="email"
                   id="exampleInputEmail">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword" class="form-label">Пароль</label>
            <input type="password"
                   class="form-control"
                   v-model="password"
                   id="exampleInputPassword">
        </div>
        <button type="button"
                class="btn btn-primary w-100"
                v-on:click="send">Войти</button>
    </form>
</template>

<script>
    import axios from "axios";
    import AlertErrorComponent from '@/components/alerts/AlertErrorComponent.vue';

    export default {
        name: 'LoginFormComponent',
        data() {
            return {
                email: null,
                password: null,
                alert: null,
                response_code: null
            };
        },
        components: {
            AlertErrorComponent
        },
        methods: {
            alertError: function (message)
            {
                this.alert = {
                    type: 'Error',
                    message: message
                };
            },
            send: function()
            {
                this.email != null && this.password != null ?
                    axios.post('api/user/auth', {
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        email: this.email,
                        password: this.password
                    })
                        .then((response) => {
                            $cookies.set('bearerToken', `Bearer ${response.data.personal_access_token}`);
                            $cookies.set('user_id', response.data.user.id);
                            console.log( $cookies.get('bearerToken'))
                            this.$router.push('/');
                        })
                        .catch((error) => {
                            this.response_code = error.statusCode;
                            this.alertError('Не удалось совершить вход в аккаунт!');
                        }) : this.alertError('Не все данные введены корректно!');
            }
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>
