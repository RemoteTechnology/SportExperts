<script>
import {
    BASE_URL,
    ENDPOINTS, MESSAGES,
    RESPONSE
} from '../../constant';
import { resetToPasswordRequest } from '../../api/UserRequest';
import { loggingRequest } from '../../api/LoggingRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';

export default {
    data() {
        return {
            baseUrl: BASE_URL,
            email: null,
            messageError: null,
            messageSuccess: null,
            currentDate: new Date(),
        };
    },
    components: {
        Card: Card,
        InputText: InputText,
        Button: Button,
        Message: Message
    },
    methods: {
        resetNotification: function() {
            let attributes = { email: this.email };
            resetToPasswordRequest(attributes)
                .then((response) => { this.messageSuccess = MESSAGES.SEND_NOTIFICATION; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'resetToPasswordRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    });
                    this.messageError = MESSAGES.NO_VALID_DATA;
                });
        }
    }
}
</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-5">
            <section class="mt-1 mb-2" v-if="this.messageSuccess">
                <Message severity="success">{{ this.messageSuccess }}</Message>
            </section>
            <section class="mt-1 mb-2" v-if="this.messageError">
                <Message severity="error">{{ this.messageError }}</Message>
            </section>
            <div class="text-center">
                <h2>Восстановление пароля</h2>
                <p>Укажите адрес электронной почты, мы на него отправим временный пароль.</p>
            </div>
            <form>
                <div class="form-block">
                    <label for="#">Введите E-mail</label>
                    <InputText type="email"
                               v-model="email"
                               class="w-100" />
                </div>
                <div class="form-block d-flex d-between">
                    <Button type="button"
                            label="Отправить письмо"
                            class="w-30"
                            severity="success"
                            @click="resetNotification" />
                </div>
            </form>
        </section>
    </section>
</template>
