<template>
    <div class="d-flex justify-content-center col-12">
        <div class="col-xxl-5 p-4">
            <div class="col-12">
                <h3 class="text-center">Регистрация</h3>
            </div>
            <form action="#" method="post">
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="exampleInputFirstName" class="form-label">Введите имя</label>
                        <input type="text"
                               class="form-control"
                               v-model="first_name"
                               v-on:input="firstNameEngAuto"
                               id="exampleInputFirstName">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="exampleInputLastName" class="form-label">Введите фамилию</label>
                        <input type="text"
                               class="form-control"
                               v-model="last_name"
                               v-on:input="lastNameEngAuto"
                               id="exampleInputLastName">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="exampleInputFirstNameEng" class="form-label">Имя на Английском</label>
                        <input type="text"
                               class="form-control"
                               v-model="first_name_eng"
                               id="exampleInputFirstNameEng"
                               disabled>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="exampleInputLastNameEng" class="form-label">Фамилия на Английском</label>
                        <input type="text"
                               class="form-control"
                               v-model="last_name_eng"
                               id="exampleInputLastNameEng"
                               disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="exampleInputBirthDate" class="form-label">Укажите дату рождения</label>
                        <input type="date"
                               class="form-control"
                               v-model="birth_date"
                               id="exampleInputBirthDate">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="exampleInputBirthDate" class="form-label">Укажите пол</label>
                        <div class="form-check" v-for="i in radiobutton">
                            <input class="form-check-input"
                                   type="radio"
                                   v-model="gender"
                                   v-bind:value="i.text"
                                   id="flexRadioGender">
                            <label class="form-check-label" for="flexRadioGender">
                                {{ i.text }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail" class="form-label">Адрес электронной почты</label>
                    <input type="email"
                           class="form-control"
                           v-model="email"
                           id="exampleInputEmail">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword" class="form-label">Пароль</label>
                    <input type="password"
                           class="form-control"
                           v-model="password"
                           id="exampleInputPassword">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPasswordDuplicate" class="form-label">Пароль ещё раз</label>
                    <input type="password"
                           class="form-control"
                           v-model="password_duplicate"
                           id="exampleInputPasswordDuplicate">
                </div>
                <button type="button"
                        class="btn btn-primary"
                        v-on:click="createNewUser">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'RegistrationView',
    data () {
        return {
            first_name: null,
            last_name: null,
            first_name_eng: null,
            last_name_eng: null,
            birth_date: null,
            gender: null,
            email: null,
            password: null,
            password_duplicate: null,
            radiobutton: [{text: 'Мужчина'}, {text: 'Женщина'}],
            charMap: {
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
                'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
                'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
                'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '',
                'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya'
            },
            spaceSymbol: ' '
        }
    },
    components: {},
    methods: {
        replacementText: function(text)
        {
            return text.split('').map(char => this.charMap[char.toLowerCase()] || char).join('');
        },
        firstNameEngAuto: function(el)
        {
            console.log(el.target.value)
            this.first_name_eng = String(this.replacementText(el.target.value)).toUpperCase();
        },
        lastNameEngAuto: function(el)
        {
            this.last_name_eng = String(this.replacementText(el.target.value)).toUpperCase();
        },
        alertError: function (message)
        {
            alert(message);
        },
        createNewUser: function()
        {
            this.password === this.password_duplicate ?
                axios.post('api/user/create ', {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    first_name: this.first_name,
                    last_name: this.last_name,
                    first_name_eng: this.first_name_eng,
                    last_name_eng: this.last_name_eng,
                    birth_date: this.birth_date,
                    gender: this.gender,
                    email: this.email,
                    password: this.password
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    }) : this.alertError('Пароли не совпадают!');
        },
    },
    beforeMount() {

    }
}
</script>

<style scoped>

</style>
