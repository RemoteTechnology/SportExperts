<script>
import {
    BASE_URL,
    ENDPOINTS,
    IDENTIFIER,
    MESSAGES
} from '../../constant';
import { getUser, updateUserRequest } from '../../api/UserRequest';
import Breadcrumb from 'primevue/breadcrumb';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Calendar from 'primevue/calendar';
import { loggingRequest } from "../../api/LoggingRequest";
import {createOptionRequest, getOptionRequest} from "../../api/OptionRequest";

export default {
    data() {
      return {
          messageSuccess: false,
          messageError: false,
          route: ENDPOINTS,
          currentDate: new Date(),
          baseUrl: BASE_URL,
          breadcrumbPages: [
              { label: 'Профиль', },
              { label: 'Настройки', },
          ],
          user: null,
          options: [
              {
                  entity: 'event_user',
                  name: 'Weight',
                  value: null,
                  type: 'string',
              },
              {
                  entity: 'event_user',
                  name: 'Height',
                  value: null,
                  type: 'string',
              },
          ],
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
            let attributes = {id: window.$cookies.get(IDENTIFIER)};
            getUser(attributes)
                .then((response) => { this.user = response.data.result.original })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getUserRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.LOADING_ERROR;
                });
        },
        userGeneralUpdate: function ()
        {
            let attributes = {
                id: window.$cookies.get(IDENTIFIER),
                first_name: this.user.first_name,
                first_name_eng: this.user.first_name_eng,
                last_name: this.user.last_name,
                last_name_eng: this.user.last_name_eng,
                birth_date: this.user.birth_date,
            };
            updateUserRequest(attributes)
                .then((response) => { if (response.status === 200) { this.messageSuccess = true; } })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'updateUserRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        userEmailUpdate: function ()
        {
            let attributes = { id: window.$cookies.get(IDENTIFIER), email: this.user.email };
            updateUserRequest(attributes)
                .then((response) => { if (response.status === 200) { this.messageSuccess = true; } })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'updateUserRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        userPhoneUpdate: function ()
        {
            let attributes = { id: window.$cookies.get(IDENTIFIER), phone: this.user.phone };
            updateUserRequest(attributes)
                .then((response) => { if (response.status === 200) { this.messageSuccess = true; } })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'updateUserRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.ERROR_ERROR;
                });
        },
        userPasswordNew: function ()
        {

        },
        userOptionsCreate: async function (idx)
        {
            if (this.options[idx].value)
            {
                let attributes = this.options[idx];
                await createOptionRequest(attributes)
                    .then((response) => {
                        this.options[idx] = response.data.result.original;
                        this.messageSuccess = MESSAGES.FORM_SUCCESS;
                    })
                    .catch((error) => {
                        this.messageError = MESSAGES.ERROR_ERROR;
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'userOptionsCreate',
                            status: error.code,
                            request_data: '',
                            message: error.message
                        })
                    });
            }
        },
        userOptionsUpdate: async function (idx)
        {
            if (this.options[idx].value)
            {
                let attributes = this.options[idx];
                await createOptionRequest(attributes)
                    .then((response) => { this.options[idx] = response.data.result.original; })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'userOptionsUpdate',
                            status: error.code,
                            request_data: '',
                            message: error.message
                        })
                    });
            }
        },
        setUserOptions: async function ()
        {
            for (let i=0; i < this.options.length; i++)
            {
                if (this.options[i].value == null)
                {
                    await this.userOptionsCreate(i);
                }
                else
                {
                    await this.userOptionsUpdate(i);
                }
            }
        },
        getUserOptions: async function()
        {
            let attributes = {
                user_id: this.user.id
            };
            await getOptionRequest(attributes)
                .then((response) => { this.options = response.data.result.original; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getOptionRequest',
                        status: error.code,
                        request_data: '',
                        message: error.message
                    })
                });
        }
    },
    beforeMount() {
        this.userIdentifier();
    }
}
</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-1 mb-2" v-if="this.messageError">
            <Message severity="error">{{ this.messageError }}</Message>
        </section>
        <section class="mt-1 mb-2" v-if="this.messageSuccess">
            <Message severity="success">{{ this.messageSuccess }}</Message>
        </section>
        <section class="mt-2 w-30 mb-5">
            <div class="d-flex d-center">
                <div class="mt-3 mb-4">
                    <Breadcrumb :model="breadcrumbPages"/>
                </div>
            </div>
            <div class="text-center mt-3 mb-3">
                <h2>Настройки профиля</h2>
                <section class="mt-1 mb-2" v-if="this.messageSuccess">
                    <Message severity="success">Данные сохранены!</Message>
                </section>
                <section class="mt-1 mb-2" v-if="this.messageError">
                    <Message severity="error">{{ this.messageError }}</Message>
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
            <Card v-if="this.user && this.user.role === 'athlete'"
                  class="mt-3">
                <template #content>
                    <h3>Параметры спортсмена</h3>
                    <small>Параметры учитываются в алгоритме жеребьёвки. Их желательно заполнить.</small>
                    <section class="d-flex d-center">
                        <div class="form-block w-100">
                            <label for="name">Рост</label>
                            <InputText type="number"
                                       v-model="this.options.height"
                                       class="w-100"
                                       :value="this.options.height"
                                       required />
                        </div>
                    </section>
                    <section class="d-flex d-center">
                        <div class="form-block w-100">
                            <label for="name">Вес</label>
                            <InputText type="number"
                                       v-model="this.options.weight"
                                       class="w-100"
                                       :value="this.options.weight"
                                       required />
                        </div>
                    </section>
                    <Button type="button"
                            label="Обновить параметры"
                            class="w-100 mt-3"
                            severity="success"
                            @click="this.setUserOptions"/>
                </template>
            </Card>
        </section>
    </section>
</template>
