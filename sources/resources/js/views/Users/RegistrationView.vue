<script>
import { baseUrl } from '../../constant';
import { registrationRequest } from '../../api/UserRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import InputMask from 'primevue/inputmask';
import FloatLabel from 'primevue/floatlabel';

export default {
    data() {
        return {
            baseUrl: baseUrl,
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
            }
            // login: null,
            // password: null,
            // gender: null,
            // name: "",
            // nameLat: "",
            // lastName: "",
            // lastNameLat: "",
            // numberPhone: "",
        };
    },
    components: {
        Card: Card,
        InputText: InputText,
        Button: Button,
        InputMask: InputMask,
        FloatLabel: FloatLabel,
    },
    methods: {
        onChange(event, nameField) {
            const result = this.translit(event.target.value);
            this[nameField] = result;
        },
        translit(word) {
            let answer = '';
            let converter = {
                'а': 'a',    'б': 'b',    'в': 'v',    'г': 'g',    'д': 'd',
                'е': 'e',    'ё': 'e',    'ж': 'zh',   'з': 'z',    'и': 'i',
                'й': 'y',    'к': 'k',    'л': 'l',    'м': 'm',    'н': 'n',
                'о': 'o',    'п': 'p',    'р': 'r',    'с': 's',    'т': 't',
                'у': 'u',    'ф': 'f',    'х': 'h',    'ц': 'c',    'ч': 'ch',
                'ш': 'sh',   'щ': 'sch',  'ь': '',     'ы': 'y',    'ъ': '',
                'э': 'e',    'ю': 'yu',   'я': 'ya',

                'А': 'A',    'Б': 'B',    'В': 'V',    'Г': 'G',    'Д': 'D',
                'Е': 'E',    'Ё': 'E',    'Ж': 'Zh',   'З': 'Z',    'И': 'I',
                'Й': 'Y',    'К': 'K',    'Л': 'L',    'М': 'M',    'Н': 'N',
                'О': 'O',    'П': 'P',    'Р': 'R',    'С': 'S',    'Т': 'T',
                'У': 'U',    'Ф': 'F',    'Х': 'H',    'Ц': 'C',    'Ч': 'Ch',
                'Ш': 'Sh',   'Щ': 'Sch',  'Ь': '',     'Ы': 'Y',    'Ъ': '',
                'Э': 'E',    'Ю': 'Yu',   'Я': 'Ya'
	        };
            for (let i = 0; i < word.length; ++i ) {
                if (converter[word[i]] == undefined){
                    answer += word[i];
                } else {
                    answer += converter[word[i]];
                }
            }
            return answer;
        },
        sendFormToSignUp: function() {
            console.log(registrationRequest(this.user))
            // registrationRequest(this.user) !== null ?
            //     /*TODO: проверить код статуса*/
            //     /*TODO: перенаправить на страницу авторизации*/:
            //     /*TODO: уведомить об ошибке и подчеркнуть поля которые были зафаршмачены*/;


        }
    }
}

</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-5">
            <div class="text-center">
                <h2>Регистрация</h2>
                <a :href="baseUrl + 'login'">
                    <Button label="Вход" severity="info" link />
                </a>
            </div>
            <form>
                <div class="d-flex d-between">
                    <div class="form-block w-46">
                        <label for="name">Имя</label>
                        <InputText type="text" id="name" v-model="name" @change="onChange($event, 'nameLat')"
                                   placeholder="Сергей" class="w-100" required />
                        <FloatLabel class="nameLatInput">
                            <label for="nameLat">Имя на латинице</label>
                            <InputText type="text" id="nameLat" v-model="nameLat" placeholder="Sergey" class="w-100" required />
                        </FloatLabel>
                    </div>
                    <div class="form-block w-46">
                        <label for="lastName">Фамилия</label>
                        <InputText type="text" id="lastName" v-model="lastName" placeholder="Губин" @change="onChange($event, 'lastNameLat')" class="w-100" required />
                        <FloatLabel class="nameLatInput">
                            <label for="lastNameLat">Фамилия на латинице</label>
                            <InputText type="text" id="lastNameLat" v-model="lastNameLat" placeholder="Gubin" class="w-100" required />
                        </FloatLabel>
                    </div>
                </div>
                <div class="form-block">
                    <label for="#">email</label>
                    <InputText type="email" v-model="email" class="w-100" required />
                </div>
                <div class="form-block">
                    <FloatLabel class="nameLatInput">
                        <label for="tel">Номер телефона</label>
                        <InputMask id="tel" v-model="numberPhone" mask="+7 (999) 999-99-99" class="w-100" />
                    </FloatLabel>
                </div>
                <div class="d-flex d-between">
                    <div class="form-block w-46">
                        <label for="#">Дата рождения</label>
                        <InputText type="date" v-model="birthday" class="w-100"/>
                    </div>
                    <div class="form-block w-46">
                        <label for="#">Укажите ваш пол</label>
                        <div class="flexing">
                            <label for="radioMale" class="w-auto">
                                <input type="radio" v-model="picked" id="radioMale" name="gender" value="male" class="w-auto" />
                                Мужской
                            </label>
                            <label for="radioFemale" class="w-auto">
                                <input type="radio" v-model="picked" id="radioFemale" name="gender" value="female" class="w-auto" />
                                Женский
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-block">
                    <label for="#">Придумайте пароль</label>
                    <InputText type="password" v-model="password" class="w-100" required />
                </div>
                <div class="form-block">
                    <label for="#">Повторите пароль</label>
                    <InputText type="password" v-model="secondPassword" class="w-100" required />
                </div>
                <div class="form-block d-flex d-between">
                    <Button label="Создать аккаунт" @click="sendFormToSignUp" class="w-100" severity="success"/>
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
