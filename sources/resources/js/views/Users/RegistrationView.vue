<script>
import {
    BASE_URL,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS,
    RESPONSE
} from "../../constant";
import { registrationRequest } from '../../api/UserRequest';
import { createInvitedRequest } from '../../api/InvitedRequest';
import { eventRecordRequest } from '../../api/ParticipantRequest';
import { createOptionRequest } from '../../api/OptionRequest';
import {getEventRequest, getKeyEventRequest} from '../../api/EventRequest';
//TODO: зафигачить опции
import { createLogOptionRequest } from '../../api/CreateLogOptionRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import InputMask from 'primevue/inputmask';
import FloatLabel from 'primevue/floatlabel';
import Message from 'primevue/message';
import { User } from '../../models/User';

export default {
    data() {
        return {
            urlKey: false,
            invite_user_id: null,
            event_id: null,
            event: null,
            participants: null,
            baseUrl: BASE_URL,
            messageSuccess: null,
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
            userObject: null,
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
            },
            option: {
                weight: null,
                height: null,
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
        getUrl: function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.size > 0)
            {
                this.invite_user_id = urlParams.get('invite_user_id');
                this.event_id = urlParams.get('event_id');
                this.urlKey = true;
            }
        },
        getKeyEvent: async function ()
        {
            let attributes = { key: this.event_id };
            await getEventRequest(attributes)
                .then((response) => {
                    this.event = response.data.result.original;
                })
                .catch((error) => {
                    createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getKeyEventRequest',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    })
                });
        },
        translation: function (argField)
        {
            return argField.split('').map(char => this.symbols[char] || char).join('');
        },
        translationFirstName: function (event) { this.user.firstNameEng = this.translation(this.user.firstName) },
        translationLastName: function (event) { this.user.lastNameEng = this.translation(this.user.lastName) },
        signUp: async function () {
            if (this.user.password && this.user.passwordDouble && this.user.password === this.user.passwordDouble) {
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

                if (this.urlKey)
                {
                    await registrationRequest(attributes)
                        .then(async (response) => {
                            this.userModel = await Object.assign(new User(), response.data.result.original)

                        })
                        .catch(async (error) => {
                            await createLogOptionRequest({
                                current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                method: 'registrationRequest',
                                status: error.code,
                                request_data: attributes.toString(),
                                message: error.message
                            })
                        });
                    let attributesInvite = {
                        who_user_id: this.invite_user_id,
                        user_id: this.userModel.id,
                    }
                    await createInvitedRequest(attributesInvite)
                        .then((response) => {  })
                        .catch((error) => {
                            createLogOptionRequest({
                                current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                method: 'createInvitedRequest',
                                status: error.code,
                                request_data: attributesInvite.toString(),
                                message: error.message
                            })
                        });
                    let attributesRecord = {
                        event_id: this.event_id,
                        user_id: this.userModel.id,
                        invited_user_id: this.invite_user_id,
                    };
                    await eventRecordRequest(attributesRecord)
                        .then(async (response) => { this.participants = await response.data.result.original; })
                        .catch((error) => {
                            createLogOptionRequest({
                                current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                method: 'registrationRequest',
                                status: error.code,
                                request_data: attributesRecord.toString(),
                                message: error.message
                            })
                        });
                    if (this.participants)
                    {
                        let attributesOptions= [
                            {
                                participant_key: this.participants.key,
                                entity: "user",
                                name: "Weight",
                                value: this.option.weight,
                                type: "string",
                            },
                            {
                                participant_key: this.participants.key,
                                entity: "user",
                                name: "Height",
                                value: this.option.height,
                                type: "string",
                            }
                        ];
                        let i = 0;
                        while(i < attributesOptions.length)
                        {
                            await createOptionRequest(attributesOptions[i])
                                .then((response) => {  })
                                .catch((error) => {
                                    createLogOptionRequest({
                                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                        method: 'createOptionRequest',
                                        status: error.code,
                                        request_data: attributesRecord.toString(),
                                        message: error.message
                                    })
                                });
                            i++;
                        }
                        this.messageSuccess = MESSAGES.FORM_SUCCESS;
                    }
                    window.location = this.baseUrl + ENDPOINTS.LOGIN;
                }
                else
                {
                    await registrationRequest(attributes)
                        .then((response) => {
                            this.messageSuccess = MESSAGES.FORM_SUCCESS;
                            // this.userModel = Object.assign(new User(), response.data.result.original);
                            window.location = this.baseUrl + ENDPOINTS.LOGIN;
                        })
                        .catch((error) => {
                            createLogOptionRequest({
                                current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                method: 'registrationRequest',
                                status: error.code,
                                request_data: attributes.toString(),
                                message: error.message
                            })
                        });
                }
            }
            else
            {
                this.messageError = MESSAGES.PASSWORD_DOUBLE;
            }
        }
    },
    async beforeMount() {
        await this.getUrl();
    }
}

</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-5">
            <section class="mt-1 mb-2" v-if="this.messageSuccess !== null">
                <Message severity="success">{{ this.messageSuccess }}</Message>
            </section>
            <section class="mt-1 mb-2" v-if="this.messageError !== null">
                <Message severity="error">{{ this.messageError }}</Message>
            </section>
            <div v-if="!this.urlKey" class="text-center">
                <h2>Регистрация</h2>
                <a :href="this.baseUrl + this.route.LOGIN">
                    <Button label="Вход" severity="info" link />
                </a>
            </div>
            <div v-else class="text-center">
                <h2>Заполните анкету</h2>
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
                    <!-- TODO: Сделать глазок (https://v3.primevue.org/password/) -->
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
                <section v-if="this.urlKey">
                    <div class="form-block">
                        <label for="#">Укажите ваш рост</label>
                        <InputText type="number"
                                   v-model="this.option.height"
                                   class="w-100" />
                    </div>
                    <div class="form-block">
                        <label for="#">Укажите ваш вес</label>
                        <InputText type="number"
                                   v-model="this.option.weight"
                                   class="w-100" />
                    </div>
                </section>
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
