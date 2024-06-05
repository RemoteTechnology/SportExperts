<script>
import {
    BASE_URL,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS,
    RESPONSE
} from "../../constant";
import { registrationRequest } from '../../api/UserRequest';
import { loggingRequest } from '../../api/LoggingRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import InputMask from 'primevue/inputmask';
import FloatLabel from 'primevue/floatlabel';
import Message from 'primevue/message';

export default {
    data() {
        return {
            baseUrl: BASE_URL,
            messageError: null,
            symbols: {
                'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh', 'З': 'Z', 'И': 'I',
                'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T',
                'У': 'U', 'Ф': 'F', 'Х': 'Kh', 'Ц': 'Ts', 'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Shch', 'Ы': 'Y', 'Э': 'E',
                'Ю': 'Yu', 'Я': 'Ya', 'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
                'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r',
                'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'shch', 'ы': 'y',
                'э': 'e', 'ю': 'yu', 'я': 'ya'
            },
            response: RESPONSE,
            route: ENDPOINTS,
            currentDate: new Date(),
            user: {
                firstName: null,
                firstNameEng: null,
                lastName: null,
                lastNameEng: null,
                birthDate: null,
                gender: null,
                email: null,
                phone: null,
                password: null,
                passwordDouble: null
            }
        };
    },
    components: {
        Card: Card,
        InputText: InputText,
        Button: Button,
        InputMask: InputMask,
        FloatLabel: FloatLabel,
        Message: Message,
    },
    methods: {
        translation: function (argField) {
            return argField.split('').map(char => this.symbols[char] || char).join('');
        },
        translationFirstName: function (event) { this.user.firstNameEng = this.translation(this.user.firstName) },
        translationLastName: function (event) { this.user.lastNameEng = this.translation(this.user.lastName) },
        signUp: function () {
            // if (this.user.password && this.user.passwordDouble && this.user.password === this.user.passwordDouble) {
                let attributes = {
                    first_name: this.user.firstName,
                    first_name_eng: this.user.firstNameEng,
                    last_name: this.user.lastName,
                    last_name_eng: this.user.lastNameEng,
                    gender: this.user.gender,
                    password: this.user.password,
                };
                if (this.user.birthDate) {
                    attributes.birth_date = this.user.birthDate;
                }
                if (this.user.email) {
                    attributes.email = this.user.email;
                }
                if (this.user.phone) {
                    attributes.phone = this.user.phone;
                }
                registrationRequest(attributes)
                    .then((response) => {
                        window.location = this.baseUrl + ENDPOINTS.LOGIN;
                    })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'registrationRequest',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        })
                    });
            // }
            // else
            // {
            //     this.messageError = MESSAGES.PASSWORD_DOUBLE;
            // }
        }
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
                <h2>Регистрация</h2>
                <a :href="this.baseUrl + this.route.LOGIN">
                    <Button label="Вход" severity="info" link />
                </a>
            </div>
            <form>
                <div class="d-flex d-between">
                    <div class="form-block w-46">
                        <label for="name">Имя</label>
                        <InputText type="text"
                                   v-model="this.user.firstName"
                                   @input="this.translationFirstName($event)"
                                   class="w-100" />
                        <label for="nameLat">Имя на латинице</label>
                        <InputText type="text"
                                   v-model="this.user.firstNameEng"
                                   class="w-100" />
                    </div>
                    <div class="form-block w-46">
                        <label for="lastName">Фамилия</label>
                        <InputText type="text"
                                   v-model="this.user.lastName"
                                   @input="translationLastName($event)"
                                   class="w-100" />
                        <label for="lastNameLat">Фамилия на латинице</label>
                        <InputText type="text"
                                   v-model="this.user.lastNameEng"
                                   class="w-100" />
                    </div>
                </div>
                <div class="form-block">
                    <label for="#">email</label>
                    <InputText type="email"
                               v-model="this.user.email"
                               class="w-100" />
                </div>
                <div class="form-block">
                    <label for="tel">Номер телефона</label>
                    <InputMask id="tel"
                               v-model="this.user.phone"
                               mask="+7 (999) 999-99-99"
                               class="w-100" />
                </div>
                <div class="d-flex d-between">
                    <div class="form-block w-46">
                        <label for="#">Дата рождения</label>
                        <InputText type="date"
                                   v-model="this.user.birthDate"
                                   class="w-100"/>
                    </div>
                    <div class="form-block w-46">
                        <label for="#">Укажите ваш пол</label>
                        <div class="flexing">
                            <label for="radioMale" class="w-auto">
                                <input type="radio"
                                       v-model="this.user.gender"
                                       name="gender"
                                       value="Мужчина"
                                       class="w-auto" />
                                Мужской
                            </label>
                            <label for="radioFemale" class="w-auto">
                                <input type="radio"
                                       v-model="this.user.gender"
                                       name="gender"
                                       value="Женщина"
                                       class="w-auto" />
                                Женский
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-block">
                    <label for="#">Придумайте пароль</label>
                    <InputText type="password"
                               v-model="this.user.password"
                               class="w-100" />
                </div>
                <div class="form-block">
                    <label for="#">Повторите пароль</label>
                    <InputText type="password"
                               v-model="this.user.passwordDouble"
                               class="w-100" />
                </div>
                <div class="form-block d-flex d-between">
                    <Button label="Создать аккаунт"
                            @click="this.signUp"
                            class="w-100"
                            severity="success"/>
                </div>
            </form>
        </section>
    </section>
</template>
<style scoped>
input:invalid {
  border: 1px solid red;
}
.flexing {
    display: flex;
    gap: 10px;
}

.nameLatInput {
    margin-top: 30px;
}
</style>
