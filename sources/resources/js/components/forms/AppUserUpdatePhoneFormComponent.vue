<script>
    import AppFormWrapperComponent from "../wrappers/AppFormWrapperComponent.vue";
    import InputMask from "primevue/inputmask";
    import Button from "primevue/button";
    import {updateUserRequest} from "../../api/UserRequest";
    import {createLogOptionRequest} from "../../api/CreateLogOptionRequest";
    import {IDENTIFIER} from "../../common/fields";
    import {MESSAGES} from "../../common/messages";

    export default {
        data()
        {
            return {
                currentDate: new Date(),
                phone: null
            };
        },
        props: {
            userPhoneProps: Object
        },
        components: {
            AppFormWrapperComponent,
            InputMask,
            Button

        },
        methods: {
            userPhoneUpdate: async function ()
            {
                let attributes = {
                    id: window.$cookies.get(IDENTIFIER),
                    phone: this.phone
                };
                await updateUserRequest(attributes)
                    .then((response) => {
                        console.log(response);
                        this.$emit('messageSuccessEmit', MESSAGES.FORM_SUCCESS);
                    })
                    .catch(async (error) => {
                        console.log(error);
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'updateUserRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        });
                        this.$emit('messageErrorEmit', MESSAGES.ERROR_ERROR);
                    });
            },
        },
        watch: {
            userPhoneProps: {
                handler(newVal) {
                    this.phone = newVal;
                },
                immediate: true,
                deep: true
            }
        }
    }
</script>

<template>
    <AppFormWrapperComponent>
        <section class="d-flex d-center">
            <div class="form-block w-100">
                <label for="name">Ваш номер телефона</label>
                <InputMask type="tel"
                           v-model="this.phone"
                           class="w-100"
                           :value="this.phone"
                           mask="+7 (999) 999-99-99"
                           required />
            </div>
        </section>
        <Button type="button"
                label="Сохранить"
                class="w-100 mt-3"
                severity="success"
                @click="this.userPhoneUpdate" />
    </AppFormWrapperComponent>
</template>
