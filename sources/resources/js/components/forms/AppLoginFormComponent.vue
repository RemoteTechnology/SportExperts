<script>
    import { authorizationRequest } from "../../api/AuthRequest";
    import { createLogOptionRequest } from "../../api/CreateLogOptionRequest";
    import Card from 'primevue/card';
    import InputText from 'primevue/inputtext';
    import InputMask from "primevue/inputmask";
    import Button from 'primevue/button';
    import AppFormWrapperComponent from "../wrappers/AppFormWrapperComponent.vue";
    import {IDENTIFIER, TOKEN} from "../../common/fields";
    import {ENDPOINTS} from "../../common/route/api";
    import {MESSAGES} from "../../common/messages";

    export default {
        data() {
          return {
              errors: [],
              login: null,
              password: null,
              currentDate: new Date(),
          };
        },
        props: {
            messageError: String,
            baseUrl: String,
            endPoint: String,
        },
        components: {
            Card,
            InputText,
            InputMask,
            Button,
            AppFormWrapperComponent,
        },
        methods: {
            isValid: function(fields) {
                this.errors = fields
            },
            authorizationRequest: async function () {
                const attributes = {
                    login: this.login,
                    password: this.password
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
                            // TODO: записать в лог
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
                        })
                    })
            },
        }
    }
</script>

<template>
    <AppFormWrapperComponent>
        <div class="form-block">
            <label for="#">Введите логин</label>
            <InputText type="text"
                       v-model="login"
                       class="w-100"
                       :invalid="this.errors !== null && 'login' in this.errors"
                        placeholder="Номер телефона/почта"/>
            <section id="errorField" v-if="this.errors !== null && 'login' in this.errors">
                <small v-for="error in this.errors.login">
                    <i class="pi pi-times-circle"></i> {{ error }}
                </small>
            </section>
        </div>
        <div class="form-block">
            <label for="#">Введите пароль</label>
            <InputText type="password"
                       v-model="password"
                       class="w-100"
                       :invalid="this.errors !== null && 'password' in this.errors" />
            <section id="errorField" v-if="this.errors !== null && 'password' in this.errors">
                <small v-for="error in this.errors.password">
                    <i class="pi pi-times-circle"></i> {{ error }}
                </small>
            </section>
        </div>
        <div class="form-block d-flex d-between wrap-reverse">
            <a :href="this.baseUrl + this.endPoint" class="m-mt-10">
                <Button type="button"
                        label="Забыли пароль?"
                        severity="info"
                        link />
            </a>
            <Button type="button" label="Войти"
                    class="w-30"
                    severity="success"
                    @click="authorizationRequest" />
        </div>
    </AppFormWrapperComponent>
</template>
