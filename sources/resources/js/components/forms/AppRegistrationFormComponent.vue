<script>
    import Card from "primevue/card";
    import InputText from "primevue/inputtext";
    import Button from "primevue/button";
    import InputMask from "primevue/inputmask";
    import FloatLabel from "primevue/floatlabel";
    import Password from "primevue/password";
    import { registrationRequest } from "../../api/UserRequest";
    import { UserModel } from "../../models/UserModel";
    import { createLogOptionRequest } from "../../api/CreateLogOptionRequest";
    import { createInvitedRequest } from "../../api/InvitedRequest";
    import { createOptionRequest } from "../../api/OptionRequest";
    import { eventRecordRequest } from "../../api/ParticipantRequest";
    import { MESSAGES } from "../../common/messages";
    import { ENDPOINTS } from "../../common/route/api";
    import AppFormWrapperComponent from "../wrappers/AppFormWrapperComponent.vue";

    export default {
        data() {
            return {
                symbols: {
                    'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh', 'З': 'Z', 'И': 'I',
                    'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T',
                    'У': 'U', 'Ф': 'F', 'Х': 'Kh', 'Ц': 'Ts', 'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Shch', 'Ы': 'Y', 'Э': 'E',
                    'Ю': 'Yu', 'Я': 'Ya', 'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
                    'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r',
                    'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'shch', 'ы': 'y',
                    'э': 'e', 'ю': 'yu', 'я': 'ya'
                },
                currentDate: new Date(),
                participants: null,
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
            };
        },
        props: {
            baseUrl: String,
            eventId: Number,
            inviteUserId: Number,
            urlKey: String,
        },
        components: {
            Card,
            InputText,
            Button,
            InputMask,
            FloatLabel,
            Password,
            AppFormWrapperComponent
        },
        methods: {
            translationFirstName: function (event) { this.user.firstNameEng = this.translation(this.user.firstName) },
            translationLastName: function (event) { this.user.lastNameEng = this.translation(this.user.lastName) },
            translation: function (argField) { return argField.split('').map(char => this.symbols[char] || char).join(''); },
            dateFormat: async function(dateStr) {
                const dateObj = await new Date(dateStr);
                const day = String(dateObj.getDate()).padStart(2, '0');
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const year = dateObj.getFullYear();
                return `${day}.${month}.${year}`;
            },
            getAttributes: async function() {
                let attributes = {
                    first_name: await this.user.firstName,
                    first_name_eng: await this.user.firstNameEng,
                    last_name: await this.user.lastName,
                    last_name_eng: await this.user.lastNameEng,
                    gender: await this.user.gender,
                    password: await this.user.password,
                };
                if (this.user.birthDate) {
                    attributes.birth_date = await this.dateFormat(this.user.birthDate);
                }
                if (this.user.email) {
                    attributes.email = await this.user.email;
                }
                if (this.user.phone) {
                    attributes.phone = await this.user.phone;
                }
                return attributes;
            },
            eventRecord: async function(attributesRecord) {
                await eventRecordRequest(attributesRecord)
                    .then(async (response) => {
                        console.log(response);
                        const data = response.data.result.original;
                        this.participants = await data.attributes;
                    })
                    .catch(async(error) => {
                        console.log(error);
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'registrationRequest',
                            status: error.code,
                            request_data: attributesRecord.toString(),
                            message: error.message
                        })
                    });
            },
            createOption: async function(attributesOptions) {
                await createOptionRequest(attributesOptions)
                    .catch(async (error) => {
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'createOptionRequest',
                            status: error.code,
                            request_data: attributesRecord.toString(),
                            message: error.message
                        })
                    });
            },
            createInvite: async function(attributesInvite) {
                await createInvitedRequest(attributesInvite)
                    .catch(async (error) => {
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'createInvitedRequest',
                            status: error.code,
                            request_data: attributesInvite.toString(),
                            message: error.message
                        })
                    });
            },
            signUp: async function () {
                if (this.user.password && this.user.passwordDouble && this.user.password === this.user.passwordDouble) {
                    const attributes = await this.getAttributes();
                    if (this.urlKey)  {
                         registrationRequest(attributes)
                            .then(async (response) => {
                                await this.$emit('messageSuccessEmit', MESSAGES.FORM_SUCCESS);
                                const data = response.data.result.original;
                                this.userModel = await Object.assign(new UserModel(), data.attributes)
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
                            who_user_id: this.inviteUserId,
                            user_id: this.userModel.id,
                        }
                        let attributesRecord = {
                            event_id: this.eventId,
                            user_id: this.userModel.id,
                            invited_user_id: this.inviteUserId,
                        };
                        let attributesOptions = [
                            {
                                user_id: this.userModel.id,
                                entity: "user",
                                name: "Weight",
                                value: this.option.weight,
                                type: "string",
                            },
                            {
                                user_id: this.userModel.id,
                                entity: "user",
                                name: "Height",
                                value: this.option.height,
                                type: "string",
                            }
                        ];
                         this.createInvite(attributesInvite);
                        let i = 0;
                        while(i < attributesOptions.length) {
                             this.createOption(attributesOptions[i]);
                            i++;
                        }
                        this.eventRecord(attributesRecord);
                       // window.location = this.baseUrl + ENDPOINTS.LOGIN;
                        return;
                    }

                    registrationRequest(attributes)
                        .then(async (response) => {
                            console.log(response)
                            const data = response.data.result.original;
                            await this.$emit('messageSuccessEmit', MESSAGES.FORM_SUCCESS);
                            this.userModel = Object.assign(new UserModel(), data.attributes);
                            window.location = this.baseUrl + ENDPOINTS.LOGIN;
                        })
                        .catch(async (error) => {
                            console.log(error)
                            await createLogOptionRequest({
                                current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                method: 'registrationRequest',
                                status: error.code,
                                request_data: attributes.toString(),
                                message: error.message
                            })
                        });
                    console.log(this.baseUrl + ENDPOINTS.LOGIN)
                } else {
                    this.$emit('messageErrorEmit', MESSAGES.PASSWORD_DOUBLE);
                }
            },
        }
    }
</script>

<template>
    <AppFormWrapperComponent>
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
            <Password toggleMask v-model="this.user.password" id="input-password" />
        </div>
        <div class="form-block">
            <label for="#">Повторите пароль</label>
            <Password toggleMask v-model="this.user.passwordDouble" id="input-password" />
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
    </AppFormWrapperComponent>
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
.p-password{
    width: 100%;
}
</style>
