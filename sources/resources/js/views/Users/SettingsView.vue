<script>
import {BASE_URL, IDENTIFIER} from '../../constant';
import { getUser, updateUser } from '../../api/UserRequest';
import Breadcrumb from 'primevue/breadcrumb';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Calendar from 'primevue/calendar';

export default {
    data() {
      return {
          alertSuccess: false,
          alertError: false,
          baseUrl: BASE_URL,
          breadcrumbPages: [
              { label: 'Профиль', },
              { label: 'Настройки', },
          ],
          user: null
      };
    },
    components: {
        Breadcrumb: Breadcrumb,
        Card: Card,
        InputText: InputText,
        InputMask: InputMask,
        Button: Button,
        Message: Message,
        Calendar: Calendar,
    },
    methods: {
        userIdentifier: function ()
        {
            getUser({id: window.$cookies.get(IDENTIFIER)})
                .then((response) => { this.user = response.data.result.original })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); });
        },
        userGeneralUpdate: function ()
        {
            updateUser({
                id: window.$cookies.get(IDENTIFIER),
                first_name: this.user.first_name,
                first_name_eng: this.user.first_name_eng,
                last_name: this.user.last_name,
                last_name_eng: this.user.last_name_eng,
                birth_date: this.user.birth_date,
            })
                .then((response) => { console.log(response); this.alertSuccess = true; })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); this.alertError = true; });
        },
        userEmailUpdate: function ()
        {
            updateUser({
                id: window.$cookies.get(IDENTIFIER),
                email: this.user.email
            })
                .then((response) => { this.alertSuccess = true })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); this.alertError = true; });
        },
        userPhoneUpdate: function ()
        {
            updateUser({
                id: window.$cookies.get(IDENTIFIER),
                phone: this.user.phone
            })
                .then((response) => { this.alertSuccess = true })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error); this.alertError = true; });
        },
        userPasswordNew: function ()
        {

        },
    },
    beforeMount() {
        this.userIdentifier();
    }
}
</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-2 w-30 mb-5">
            <div class="d-flex d-center">
                <div class="mt-3 mb-4">
                    <Breadcrumb :model="breadcrumbPages"/>
                </div>
            </div>
            <div class="text-center mt-3 mb-3">
                <h2>Настройки профиля</h2>
                <section class="mt-1 mb-2" v-if="this.alertSuccess">
                    <Message severity="success">Данные сохранены!</Message>
                </section>
                <section class="mt-1 mb-2" v-if="this.alertError">
                    <Message severity="error">Ошибка сохранения данных!</Message>
                </section>
            </div>
            <Card>
                <template #content>
                    <h3>Общая информация:</h3>
                    <form>
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
                                          dateFormat="dd.mm.yy"
                                          showIcon
                                          required />
                            </div>
                        </section>
                        <Button type="button"
                                label="Сохранить"
                                class="w-100 mt-3"
                                severity="success"
                                @click="this.userGeneralUpdate" />
                    </form>
                </template>
            </Card>
            <Card class="mt-3">
                <template #content>
                    <h3>Сменить адрес электронной почты</h3>
                    <form>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Адрес электронной почты</label>
                                <InputText type="email"
                                           v-model="this.user.email"
                                           class="w-100"
                                           :value="this.user.email"
                                           required />
                            </div>
                        </section>
                        <Button type="button"
                                label="Сохранить"
                                class="w-100 mt-3"
                                severity="success"
                                @click="this.userEmailUpdate" />
                    </form>
                </template>
            </Card>
            <Card class="mt-3">
                <template #content>
                    <h3>Сменить номер телефона</h3>
                    <form>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Ваш номер телефона</label>
                                <InputMask type="tel"
                                           v-model="this.user.phone"
                                           class="w-100"
                                           :value="this.user.phone"
                                           mask="+7 (999) 999-99-99"
                                           required />
                            </div>
                        </section>
                        <Button type="button"
                                label="Сохранить"
                                class="w-100 mt-3"
                                severity="success"
                                @click="this.userPhoneUpdate" />
                    </form>
                </template>
            </Card>
            <Card class="mt-3">
                <template #content>
                    <h3>Сменить пароль</h3>
                    <section class="d-flex d-center">
                        <div class="form-block w-100">
                            <label for="name">Укажите адрес электронной почты</label>
                            <InputText type="email"
                                       v-model="this.user.email"
                                       class="w-100"
                                       :value="this.user.email"
                                       required />
                            <small>На этот адрес вам будет выслана ссылка для смены пароля.</small>
                        </div>
                    </section>
                    <Button type="button"
                            label="Отправить пароль"
                            class="w-100 mt-3"
                            severity="primary"
                            @click="this.userPasswordNew"/>
                </template>
            </Card>
        </section>
    </section>
</template>
