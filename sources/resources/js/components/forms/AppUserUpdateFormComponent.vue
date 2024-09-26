<script>
    import AppFormWrapperComponent from "../wrappers/AppFormWrapperComponent.vue";
    import {IDENTIFIER, MESSAGES} from "../../constant";
    import {updateUserRequest} from "../../api/UserRequest";
    import {createLogOptionRequest} from "../../api/CreateLogOptionRequest";
    import InputText from "primevue/inputtext";
    import Calendar from "primevue/calendar";
    import Button from "primevue/button";

    export default {
        data() {
          return {
              currentDate: new Date(),
              user: null,
          }
        },
        props: {
            userProps: Object
        },
        components: {
            AppFormWrapperComponent,
            InputText,
            Calendar,
            Button
        },
        methods: {
            dateFormat: async function(dateStr) {
                const dateObj = await new Date(dateStr);
                const day = String(dateObj.getDate()).padStart(2, '0');
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const year = dateObj.getFullYear();
                return `${day}.${month}.${year}`;
            },
            userUpdate: async function ()
            {
                let attributes = {
                    id: window.$cookies.get(IDENTIFIER),
                    first_name: this.user.first_name,
                    first_name_eng: this.user.first_name_eng,
                    last_name: this.user.last_name,
                    last_name_eng: this.user.last_name_eng,
                    birth_date: await this.dateFormat(this.user.birth_date),
                };
                await updateUserRequest(attributes)
                    .then((response) => {
                        console.log(response);
                        this.messageSuccess = 'Данные сохранены';
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
            userProps: {
                handler(newVal) {
                    this.user = newVal;
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
                <label for="name">Имя</label>
                <InputText type="text"
                           v-model="this.user.first_name"
                           class="w-100"
                           :value="this.user.first_name"
                           required />
            </div>
        </section>
        <section class="d-flex d-center">
            <div class="form-block w-100">
                <label for="name">Имя на Английском</label>
                <InputText type="text"
                           v-model="this.user.first_name_eng"
                           class="w-100"
                           :value="this.user.first_name_eng"
                           required />
            </div>
        </section>
        <section class="d-flex d-center">
            <div class="form-block w-100">
                <label for="name">Фамилия</label>
                <InputText type="text"
                           v-model="this.user.last_name"
                           class="w-100"
                           :value="this.user.last_name"
                           required />
            </div>
        </section>
        <section class="d-flex d-center">
            <div class="form-block w-100">
                <label for="name">Фамилия на Английском</label>
                <InputText type="text"
                           v-model="this.user.last_name_eng"
                           class="w-100"
                           :value="this.user.last_name_eng"
                           required />
            </div>
        </section>
        <section class="d-flex d-center">
            <div class="form-block w-100">
                <label for="name">Дата рождения</label>
                <Calendar type="date"
                          :showOnFocus="false"
                          inputId="buttondisplay"
                          v-model="this.user.birth_date"
                          class="w-100"
                          :value="this.user.birth_date"
                          dateFormat="dd.mm.yyyy"
                          showIcon
                          required />
            </div>
        </section>
        <Button type="button"
                label="Сохранить"
                class="w-100 mt-3"
                severity="success"
                @click="this.userUpdate" />
    </AppFormWrapperComponent>
</template>
